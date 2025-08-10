export const metadata = {
  title: "Design Marketplace",
  description: "AI-generated patterns and products"
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body style={{ fontFamily: 'sans-serif', margin: 0 }}>
        <header style={{ padding: '12px 20px', borderBottom: '1px solid #eee', display: 'flex', gap: 16 }}>
          <a href="/">Marketplace</a>
          <a href="/generator">AI Generator</a>
        </header>
        <main style={{ padding: 20 }}>{children}</main>
      </body>
    </html>
  );
}