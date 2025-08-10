import express from 'express';
import cors from 'cors';
import dotenv from 'dotenv';

dotenv.config();

const app = express();
app.use(express.json());

const allowedOrigin = process.env.ALLOWED_ORIGIN || 'http://localhost:3000';
app.use(cors({ origin: allowedOrigin, credentials: true }));

app.get('/health', (_req, res) => {
  res.json({ ok: true });
});

// Mock auth middleware: attaches user_id
app.use((req, _res, next) => {
  // In real impl, verify JWT from cookie or header
  (req as any).user_id = 'user_dev_123';
  next();
});

app.get('/subscriptions/me', (req, res) => {
  // Replace with Medusa-backed subscription check
  res.json({ tier: 'free', credits_remaining: 10, user_id: (req as any).user_id });
});

app.post('/designs/link', (req, res) => {
  // Attach job_id to a hypothetical cart line item (mock)
  const { job_id, product_template_id } = req.body || {};
  if (!job_id) return res.status(400).json({ error: 'job_id required' });
  res.json({ ok: true, job_id, product_template_id });
});

// Callback from AI service when job completes
app.post('/ai/callback', (req, res) => {
  const { job_id, user_id, previews, assets, meta } = req.body || {};
  console.log('AI callback:', { job_id, user_id, previews, assets, meta });
  res.json({ ok: true });
});

const port = Number(process.env.PORT || 4000);
app.listen(port, () => {
  console.log(`API listening on http://localhost:${port}`);
});