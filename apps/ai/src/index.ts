import express from 'express';
import cors from 'cors';
import dotenv from 'dotenv';
import { v4 as uuidv4 } from 'uuid';
import path from 'node:path';
import fs from 'node:fs/promises';
import fssync from 'node:fs';
import { PNG } from 'pngjs';
import fetch from 'node-fetch';

dotenv.config();

const app = express();
app.use(express.json({ limit: '2mb' }));

const allowedOrigin = process.env.ALLOWED_ORIGIN || 'http://localhost:3000';
app.use(cors({ origin: allowedOrigin, credentials: true }));

const PORT = Number(process.env.PORT || 5000);
const PUBLIC_BASE_URL = process.env.PUBLIC_BASE_URL || `http://localhost:${PORT}`;
const STORAGE_DIR = path.join(process.cwd(), 'storage');
const PREVIEWS_DIR = path.join(STORAGE_DIR, 'previews');
const PRINT_DIR = path.join(STORAGE_DIR, 'print');

// Ensure storage directories exist
for (const dir of [STORAGE_DIR, PREVIEWS_DIR, PRINT_DIR]) {
  if (!fssync.existsSync(dir)) fssync.mkdirSync(dir, { recursive: true });
}

// Serve static files
app.use('/previews', express.static(PREVIEWS_DIR));
app.use('/print', express.static(PRINT_DIR));

interface Job {
  id: string;
  user_id: string;
  prompt: string;
  status: 'queued' | 'running' | 'succeeded' | 'failed';
  progress?: number;
  previews?: Array<{ url: string; width: number; height: number; bytes: number }>;
  assets?: Array<{ url: string; width: number; height: number; bytes: number; icc?: string; ppi?: number; bleed_mm?: number }>;
  created_at: string;
  error?: string;
}

const jobs = new Map<string, Job>();

app.get('/health', (_req, res) => {
  res.json({ ok: true });
});

// Mock auth extractor
function getUserId() {
  return 'user_dev_123';
}

app.post('/generate', async (req, res) => {
  const { prompt = '', size = 'poster-18x24' } = req.body || {};
  if (!prompt || typeof prompt !== 'string') {
    return res.status(400).json({ error: 'prompt required' });
  }
  const id = uuidv4();
  const user_id = getUserId();
  const job: Job = { id, user_id, prompt, status: 'queued', created_at: new Date().toISOString(), progress: 0 };
  jobs.set(id, job);

  // Simulate async work
  simulateGeneration(job).catch((err) => {
    const j = jobs.get(id);
    if (j) {
      j.status = 'failed';
      j.error = String(err?.message || err);
      j.progress = undefined;
      jobs.set(id, j);
    }
  });

  res.json({ job_id: id });
});

app.get('/jobs/:id', (req, res) => {
  const job = jobs.get(req.params.id);
  if (!job) return res.status(404).json({ error: 'not found' });
  res.json(job);
});

async function simulateGeneration(job: Job) {
  // Step 1: running
  updateJob(job.id, { status: 'running', progress: 10 });
  await sleep(400);

  // Step 2: create a preview image—render simple pattern with a caption band
  updateJob(job.id, { progress: 40 });
  const previewPath = await renderPreview(job.id, job.prompt);
  const previewUrl = `${PUBLIC_BASE_URL}/previews/${path.basename(previewPath)}`;
  const previewStats = await fs.stat(previewPath);

  updateJob(job.id, {
    progress: 75,
    previews: [{ url: previewUrl, width: 1024, height: 1024, bytes: previewStats.size }]
  });
  await sleep(400);

  // Step 3: create a print-ready mock file
  const printPath = await renderPrint(job.id, job.prompt);
  const printUrl = `${PUBLIC_BASE_URL}/print/${path.basename(printPath)}`;
  const printStats = await fs.stat(printPath);

  updateJob(job.id, {
    status: 'succeeded',
    progress: 100,
    assets: [{ url: printUrl, width: 3600, height: 5400, bytes: printStats.size, ppi: 300, bleed_mm: 3 }]
  });

  // Notify API callback if configured
  const callbackUrl = process.env.API_CALLBACK_URL;
  if (callbackUrl) {
    try {
      await fetch(callbackUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          job_id: job.id,
          user_id: job.user_id,
          previews: jobs.get(job.id)?.previews || [],
          assets: jobs.get(job.id)?.assets || [],
          meta: { prompt: job.prompt }
        })
      });
    } catch (e) {
      console.warn('Callback failed', e);
    }
  }
}

function updateJob(id: string, patch: Partial<Job>) {
  const existing = jobs.get(id);
  if (!existing) return;
  const updated = { ...existing, ...patch };
  jobs.set(id, updated);
}

function drawCaptionBand(png: PNG, yFromBottom: number, bandHeight: number, alpha = 180) {
  const { width, height } = png;
  for (let y = height - yFromBottom - bandHeight; y < height - yFromBottom; y++) {
    for (let x = 0; x < width; x++) {
      const idx = (width * y + x) << 2;
      png.data[idx] = 255;
      png.data[idx + 1] = 255;
      png.data[idx + 2] = 255;
      png.data[idx + 3] = alpha;
    }
  }
}

async function renderPreview(jobId: string, prompt: string): Promise<string> {
  const size = 1024;
  const png = new PNG({ width: size, height: size });

  for (let y = 0; y < size; y++) {
    const on = Math.floor(y / 32) % 2 === 0;
    const r = on ? 14 : 6; // teal-ish blue tones
    const g = on ? 165 : 182;
    const b = on ? 233 : 212;
    for (let x = 0; x < size; x++) {
      const idx = (size * y + x) << 2;
      png.data[idx] = r;
      png.data[idx + 1] = g;
      png.data[idx + 2] = b;
      png.data[idx + 3] = 255;
    }
  }

  drawCaptionBand(png, 16, 80, 180);

  const buffer = PNG.sync.write(png);
  const filename = `${jobId}_preview.png`;
  const fullPath = path.join(PREVIEWS_DIR, filename);
  await fs.writeFile(fullPath, buffer);
  return fullPath;
}

async function renderPrint(jobId: string, prompt: string): Promise<string> {
  const width = 3600;
  const height = 5400;
  const png = new PNG({ width, height });

  const tile = 60;
  for (let y = 0; y < height; y++) {
    for (let x = 0; x < width; x++) {
      const on = (Math.floor(x / tile) + Math.floor(y / tile)) % 2 === 0;
      const r = on ? 15 : 6; // deep greens
      const g = on ? 118 : 78;
      const b = on ? 110 : 59;
      const idx = (width * y + x) << 2;
      png.data[idx] = r;
      png.data[idx + 1] = g;
      png.data[idx + 2] = b;
      png.data[idx + 3] = 255;
    }
  }

  drawCaptionBand(png, 40, 100, 160);

  const buffer = PNG.sync.write(png);
  const filename = `${jobId}_print.png`;
  const fullPath = path.join(PRINT_DIR, filename);
  await fs.writeFile(fullPath, buffer);
  return fullPath;
}

function sleep(ms: number) {
  return new Promise((r) => setTimeout(r, ms));
}

app.listen(PORT, () => {
  console.log(`AI service listening on ${PUBLIC_BASE_URL}`);
});