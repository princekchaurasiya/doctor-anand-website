import { Head, Link } from '@inertiajs/react';

import { appPath } from '@/lib/paths';
import { useMemo } from 'react';

import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import { Stack } from '@/Components/ui/Stack';
import MainLayout from '@/Layouts/MainLayout';
import type { BlogPostSummary, PaginationMeta } from '@/types';

type Props = {
  posts: BlogPostSummary[];
  meta: PaginationMeta;
};

function estimatedReadMinutes(excerpt: string | null): number {
  if (!excerpt) {
    return 5;
  }
  const words = excerpt.trim().split(/\s+/).filter(Boolean).length;
  return Math.max(4, Math.min(22, Math.round(words * 0.45)));
}

export default function Blog({ posts, meta }: Props) {
  const summaries = useMemo(
    () =>
      posts.map((p) => ({
        post: p,
        readMin: estimatedReadMinutes(p.excerpt),
      })),
    [posts]
  );

  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
        <Head title="Health tips & updates | Mumbai home care">
          <meta name="description" content="Articles on home healthcare, elderly safety, and Mumbai-focused medical tips." />
        </Head>
        <PageHeader title="Blog" subtitle="Practical guidance for families choosing care at home in Mumbai." />
        <Stack gap="1rem">
          {summaries.map(({ post, readMin }) => (
            <Card key={post.id} as="article">
              {post.image ? (
                <img
                  src={post.image}
                  alt={post.title}
                  style={{
                    width: '100%',
                    maxHeight: 200,
                    objectFit: 'cover',
                    borderRadius: 'var(--radius)',
                    marginBottom: '0.75rem',
                    display: 'block',
                  }}
                />
              ) : null}
              <p style={{ margin: 0, fontSize: '0.85rem', color: 'var(--color-muted)' }}>
                {post.category ?? 'Healthcare'} · <span style={{ fontWeight: 700, color: 'var(--color-primary)' }}>{readMin} min read</span>
              </p>
              <h2 style={{ margin: '0.25rem 0' }}>
                <Link href={appPath(`/blog/${post.slug}`)}>{post.title}</Link>
              </h2>
              {post.excerpt && <p style={{ color: 'var(--color-muted)' }}>{post.excerpt}</p>}
              {(post.tags ?? []).length > 0 ? (
                <div style={{ display: 'flex', flexWrap: 'wrap', gap: '0.35rem', marginTop: '0.5rem' }}>
                  {(post.tags ?? []).map((t) => (
                    <span
                      key={t}
                      style={{
                        fontSize: '0.72rem',
                        fontWeight: 700,
                        padding: '0.2rem 0.55rem',
                        borderRadius: 999,
                        background: '#fff2f4',
                        color: 'var(--color-primary-dark)',
                        border: '1px solid rgba(200, 16, 46, 0.2)',
                      }}
                    >
                      {t}
                    </span>
                  ))}
                </div>
              ) : null}
            </Card>
          ))}
          <p style={{ color: 'var(--color-muted)', fontSize: '0.9rem' }}>
            Page {meta.current_page} of {meta.last_page} — {meta.total} posts
          </p>
        </Stack>
      </div>
    </MainLayout>
  );
}
