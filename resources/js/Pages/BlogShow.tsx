import { Head, usePage } from '@inertiajs/react';
import { useEffect, useMemo, useRef } from 'react';

import { BlogTableOfContents } from '@/Components/BlogTableOfContents';
import { Card } from '@/Components/ui/Card';
import MainLayout from '@/Layouts/MainLayout';
import type { BlogPost, Site } from '@/types';

type Props = {
  post: BlogPost;
};

function readingMinutesFromHtml(html: string): number {
  const text = html.replace(/<[^>]+>/g, ' ');
  const words = text.trim().split(/\s+/).filter(Boolean).length;
  return Math.max(1, Math.round(words / 200));
}

function slugifyHeading(text: string, index: number): string {
  const base = text
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '');
  return base || `heading-${index}`;
}

function formatPublishedDate(iso: string | null): string | null {
  if (!iso) {
    return null;
  }
  try {
    return new Date(iso).toLocaleDateString('en-IN', {
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    });
  } catch {
    return null;
  }
}

export default function BlogShow({ post }: Props) {
  const { site } = usePage<{ site: Site | null }>().props;
  const proseRef = useRef<HTMLDivElement>(null);
  const title = post.meta_title ?? post.title;
  const desc = post.meta_description ?? post.excerpt ?? undefined;
  const toc = post.table_of_contents ?? [];
  const tags = post.tags ?? [];
  const faqs = post.faq_schema ?? [];
  const readMin = useMemo(() => readingMinutesFromHtml(post.body), [post.body]);
  const publishedLabel = formatPublishedDate(post.published_at);

  const baseUrl = (site?.frontend_public_url ?? '').replace(/\/$/, '') || (typeof window !== 'undefined' ? window.location.origin : '');
  const canonical = `${baseUrl}/blog/${post.slug}`;
  const ogImage = post.image ?? site?.images?.og ?? null;

  useEffect(() => {
    const root = proseRef.current;
    if (!root || !toc.length) {
      return;
    }
    const h2s = root.querySelectorAll('h2');
    toc.forEach((text, i) => {
      const el = h2s[i];
      if (el) {
        el.id = slugifyHeading(text, i);
      }
    });
  }, [post.body, toc]);

  const articleJsonLd = {
    '@context': 'https://schema.org',
    '@type': 'Article',
    headline: post.title,
    description: desc ?? undefined,
    datePublished: post.published_at ?? undefined,
    author: {
      '@type': 'Organization',
      name: site?.site_name ?? 'Doconnect',
    },
    publisher: {
      '@type': 'Organization',
      name: site?.site_name ?? 'Doconnect',
    },
    image: ogImage ?? undefined,
    mainEntityOfPage: canonical,
  };

  const faqJsonLd =
    faqs.length > 0
      ? {
          '@context': 'https://schema.org',
          '@type': 'FAQPage',
          mainEntity: faqs.map((f) => ({
            '@type': 'Question',
            name: f.question,
            acceptedAnswer: {
              '@type': 'Answer',
              text: f.answer,
            },
          })),
        }
      : null;

  return (
    <MainLayout>
      <Head title={title}>
        {desc ? <meta name="description" content={desc} /> : null}
        <link rel="canonical" href={canonical} />
        <meta property="og:type" content="article" />
        <meta property="og:title" content={title} />
        {desc ? <meta property="og:description" content={desc} /> : null}
        <meta property="og:url" content={canonical} />
        {ogImage ? <meta property="og:image" content={ogImage} /> : null}
        <meta name="twitter:card" content="summary_large_image" />
        <script type="application/ld+json">{JSON.stringify(articleJsonLd)}</script>
        {faqJsonLd ? <script type="application/ld+json">{JSON.stringify(faqJsonLd)}</script> : null}
      </Head>

      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
        <div
          style={{
            display: 'grid',
            gap: '1.5rem',
            alignItems: 'start',
            gridTemplateColumns: toc.length > 0 ? 'minmax(0, 1fr) minmax(0, 280px)' : '1fr',
          }}
          className="blog-show-grid"
        >
          <Card as="article" style={{ overflow: 'hidden' }}>
            <div className="blog-post">
            {post.image ? (
              <img
                src={post.image}
                alt={post.title}
                style={{
                  width: '100%',
                  maxHeight: 320,
                  objectFit: 'cover',
                  borderRadius: 'var(--radius)',
                  marginBottom: '1rem',
                  display: 'block',
                }}
              />
            ) : null}
            <header style={{ marginBottom: '1.25rem', paddingBottom: '1.25rem', borderBottom: '1px solid rgba(200, 16, 46, 0.12)' }}>
              <p style={{ margin: 0, color: 'var(--color-muted)', fontSize: '0.9rem', fontWeight: 600 }}>
                {post.category ?? 'Healthcare'}
                {publishedLabel ? ` · ${publishedLabel}` : ''}
              </p>
              <h1
                style={{
                  margin: '0.5rem 0 0',
                  fontSize: 'clamp(1.65rem, 4vw, 2.15rem)',
                  fontWeight: 800,
                  lineHeight: 1.2,
                  color: 'var(--color-primary)',
                }}
              >
                {post.title}
              </h1>
              {post.excerpt ? (
                <p style={{ fontSize: '1.1rem', color: 'var(--color-muted)', margin: '0.85rem 0 0', lineHeight: 1.6 }}>{post.excerpt}</p>
              ) : null}
              <p style={{ margin: '0.75rem 0 0', fontSize: '0.88rem', color: 'var(--color-muted)' }}>
                <span style={{ fontWeight: 700, color: 'var(--color-primary)' }}>{readMin} min read</span>
              </p>
            </header>
            {tags.length > 0 ? (
              <div style={{ display: 'flex', flexWrap: 'wrap', gap: '0.4rem', marginTop: '0.85rem' }}>
                {tags.map((t) => (
                  <span
                    key={t}
                    style={{
                      fontSize: '0.78rem',
                      fontWeight: 700,
                      padding: '0.25rem 0.65rem',
                      borderRadius: 999,
                      background: '#fff2f4',
                      color: 'var(--color-primary-dark)',
                      border: '1px solid rgba(200, 16, 46, 0.25)',
                    }}
                  >
                    {t}
                  </span>
                ))}
              </div>
            ) : null}
            <div ref={proseRef} className="prose" dangerouslySetInnerHTML={{ __html: post.body }} />
            </div>
          </Card>

          {toc.length > 0 ? <BlogTableOfContents items={toc} slugify={slugifyHeading} /> : null}
        </div>
      </div>

    </MainLayout>
  );
}
