import { Head, usePage } from '@inertiajs/react';

import { Card } from '@/Components/ui/Card';
import { ErrorAlert } from '@/Components/ui/ErrorAlert';
import { PageHeader } from '@/Components/ui/PageHeader';
import { Stack } from '@/Components/ui/Stack';
import MainLayout from '@/Layouts/MainLayout';
import type { Site, SiteTestimonial } from '@/types';

type Props = {
  testimonials?: SiteTestimonial[] | null;
};

export default function Testimonials({ testimonials }: Props) {
  const { site } = usePage<{ site: Site | null }>().props;
  const items: SiteTestimonial[] = Array.isArray(testimonials) ? testimonials : [];

  if (!site) {
    return (
      <MainLayout>
        <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
          <ErrorAlert title="Configuration" message="Site settings are missing." />
        </div>
      </MainLayout>
    );
  }

  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
      <Head title="Testimonials | Doconnect" />
      <PageHeader title="Testimonials" subtitle="What our clients say about Doconnect." />
      {items.length === 0 ? (
        <p style={{ color: 'var(--color-muted)' }}>Testimonials will appear here soon.</p>
      ) : (
        <Stack gap="1rem">
          {items.map((t, i) => (
            <Card key={`${t.name}-${i}`} as="blockquote">
              <p style={{ margin: 0, fontSize: '1.05rem', lineHeight: 1.6 }}>&ldquo;{t.quote}&rdquo;</p>
              <footer style={{ marginTop: '0.75rem', fontWeight: 600, color: 'var(--color-primary)' }}>— {t.name}</footer>
            </Card>
          ))}
        </Stack>
      )}
      </div>
    </MainLayout>
  );
}
