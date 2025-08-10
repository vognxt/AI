export type GenerationStatus = "queued" | "running" | "succeeded" | "failed";

export interface PreviewAssetMeta {
  url: string;
  width: number;
  height: number;
  bytes: number;
}

export interface PrintAssetMeta extends PreviewAssetMeta {
  icc?: string;
  ppi?: number;
  bleed_mm?: number;
}

export interface GenerateRequestBody {
  prompt: string;
  product_template_id?: string;
  size?: string;
  colorway?: string;
  style_hints?: string[];
  guidance_scale?: number;
  seed?: number;
  upscale?: boolean;
}

export interface GenerateJob {
  id: string;
  user_id: string;
  prompt: string;
  status: GenerationStatus;
  progress?: number;
  previews?: PreviewAssetMeta[];
  assets?: PrintAssetMeta[];
  created_at: string;
  error?: string;
}

export interface SubscriptionInfo {
  tier: "free" | "pro" | "enterprise";
  credits_remaining: number;
}