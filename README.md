# Design Platform Monorepo

Apps:
- apps/web: Next.js frontend (generator UI, catalog)
- apps/api: Node API (mock Medusa endpoints)
- apps/ai: Node AI microservice (job queue + file generation, local storage; S3 optional)

## Quickstart

1. Install deps

```bash
npm install
```

2. Copy env examples and adjust as needed

```bash
cp apps/web/.env.example apps/web/.env
cp apps/api/.env.example apps/api/.env
cp apps/ai/.env.example apps/ai/.env
```

3. Run all apps in dev

```bash
npm run dev
```

- Web: http://localhost:3000
- API: http://localhost:4000
- AI:  http://localhost:5000

## Notes
- By default, the AI service stores generated previews/prints under `apps/ai/storage` and serves them statically.
- Configure AWS to upload to S3 by setting env vars in `apps/ai/.env`.
- The API mimics Medusa endpoints and auth. Replace with Medusa later if desired.
