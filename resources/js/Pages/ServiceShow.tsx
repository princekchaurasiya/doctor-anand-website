import { Head } from '@inertiajs/react';

import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import MainLayout from '@/Layouts/MainLayout';
import type { Service } from '@/types';

type Props = {
  service: Service;
};

export default function ServiceShow({ service }: Props) {
  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
        <Head title={`${service.title} | Satatva Health Mumbai`}>
          <meta name="description" content={service.short_description} />
        </Head>
        <Card as="article">
          {service.image ? (
            <img
              src={service.image}
              alt={service.title}
              style={{
                width: '100%',
                maxHeight: 280,
                objectFit: 'cover',
                borderRadius: 'var(--radius)',
                marginBottom: '1rem',
                display: 'block',
              }}
            />
          ) : null}
          <PageHeader title={service.title} />
          <p style={{ color: 'var(--color-muted)' }}>{service.short_description}</p>
          {service.body && <div style={{ marginTop: '1rem' }} dangerouslySetInnerHTML={{ __html: service.body }} />}
        </Card>
      </div>
    </MainLayout>
  );
}
