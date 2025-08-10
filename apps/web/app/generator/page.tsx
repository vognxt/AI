"use client";
import { useState } from "react";
import Image from "next/image";

export default function GeneratorPage() {
  const [prompt, setPrompt] = useState("");
  const [jobId, setJobId] = useState<string | null>(null);
  const [status, setStatus] = useState<any>(null);
  const [loading, setLoading] = useState(false);

  const AI_URL = process.env.NEXT_PUBLIC_AI_URL || "http://localhost:5000";

  async function submit(e: React.FormEvent) {
    e.preventDefault();
    setLoading(true);
    setStatus(null);
    setJobId(null);
    const res = await fetch(`${AI_URL}/generate`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ prompt, size: "poster-18x24" })
    });
    const data = await res.json();
    setJobId(data.job_id);
    setLoading(false);
    poll(data.job_id);
  }

  async function poll(id: string) {
    const url = `${AI_URL}/jobs/${id}`;
    const iv = setInterval(async () => {
      const r = await fetch(url);
      const d = await r.json();
      setStatus(d);
      if (d.status === "succeeded" || d.status === "failed") {
        clearInterval(iv);
      }
    }, 800);
  }

  return (
    <div>
      <h1>AI Generator</h1>
      <form onSubmit={submit} style={{ display: 'flex', gap: 8, marginBottom: 12 }}>
        <input
          value={prompt}
          onChange={(e) => setPrompt(e.target.value)}
          placeholder="e.g., retro geometric pattern in teal and coral"
          style={{ flex: 1, padding: 8 }}
        />
        <button disabled={!prompt || loading} type="submit">Generate</button>
      </form>
      {jobId && <p>Job: {jobId}</p>}
      {status && (
        <div>
          <p>Status: {status.status} {status.progress ? `(${status.progress}%)` : ''}</p>
          {status.previews?.length ? (
            <div style={{ display: 'flex', gap: 12, flexWrap: 'wrap' }}>
              {status.previews.map((p: any, i: number) => (
                <div key={i}>
                  {/* eslint-disable-next-line @next/next/no-img-element */}
                  <img src={p.url} alt="preview" width={256} />
                </div>
              ))}
            </div>
          ) : null}
        </div>
      )}
    </div>
  );
}