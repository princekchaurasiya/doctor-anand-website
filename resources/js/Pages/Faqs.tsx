import { Head, usePage } from '@inertiajs/react';

import { Card } from '@/Components/ui/Card';
import { ErrorAlert } from '@/Components/ui/ErrorAlert';
import { PageHeader } from '@/Components/ui/PageHeader';
import { Stack } from '@/Components/ui/Stack';
import MainLayout from '@/Layouts/MainLayout';
import type { Site, SiteFaq } from '@/types';

type Props = {
  faqs?: SiteFaq[] | null;
};

export default function Faqs({ faqs }: Props) {
  const { site } = usePage<{ site: Site | null }>().props;
  const items: SiteFaq[] = Array.isArray(faqs) ? faqs : [];

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
      <Head title="FAQs | Doconnect" />
      <PageHeader
        title="Frequently asked questions"
        subtitle="Answers about booking and home visit services in Mumbai."
      />
      {items.length === 0 ? (
        <p style={{ color: 'var(--color-muted)' }}>FAQs will appear here soon.</p>
      ) : (
        <Stack gap="1rem">
          {items.map((faq, i) => (
            <Card key={i} as="section">
              <h2 style={{ marginTop: 0, fontSize: '1.05rem' }}>{faq.question}</h2>
              <p style={{ margin: 0, color: 'var(--color-muted)', lineHeight: 1.65 }}>{faq.answer}</p>
            </Card>
          ))}
        </Stack>
      )}
      </div>
    </MainLayout>
  );
}
