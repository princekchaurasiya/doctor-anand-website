import { Head, Link } from '@inertiajs/react';

import { appPath } from '@/lib/paths';
import { serviceIcon } from '@/lib/serviceIcons';

import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import MainLayout from '@/Layouts/MainLayout';
import type { Service } from '@/types';

type Props = {
  services: Service[];
};

export default function Services({ services }: Props) {
  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
        <Head title="Surgical services | Satatva Health Mumbai">
          <meta
            name="description"
            content="Piles, fistula, fissure, hernia, gallbladder, hydrocele, and general surgery by Dr. Anand S. Prajapati at Satatv Clinic, Kandivali West."
          />
        </Head>
        <PageHeader
          title="Our services"
          subtitle="General and laser surgery at Satatv Clinic, Kandivali West — choose a service to learn more."
        />
        <img
          src="/images/dr-anand/services-board.png"
          alt="Surgical services board — Satatva Health"
          loading="lazy"
          style={{
            width: '100%',
            maxWidth: 560,
            borderRadius: 'var(--radius)',
            marginBottom: '1.5rem',
            display: 'block',
            boxShadow: 'var(--shadow)',
          }}
        />
        <div style={{ display: 'grid', gap: '1rem', gridTemplateColumns: 'repeat(auto-fill, minmax(260px, 1fr))' }}>
          {services.map((s) => {
            const Icon = serviceIcon(s.slug);
            return (
              <Card key={s.id} as="section">
                <div style={{ display: 'flex', alignItems: 'flex-start', gap: '0.85rem' }}>
                  <div
                    style={{
                      width: 52,
                      height: 52,
                      borderRadius: '50%',
                      display: 'grid',
                      placeItems: 'center',
                      background: '#f3eef8',
                      color: 'var(--color-primary)',
                      flexShrink: 0,
                    }}
                  >
                    <Icon size={26} strokeWidth={2} aria-hidden />
                  </div>
                  <div style={{ flex: 1, minWidth: 0 }}>
                    <h2 style={{ marginTop: 0, fontSize: '1.15rem' }}>{s.title}</h2>
                    <p style={{ color: 'var(--color-muted)' }}>{s.short_description}</p>
                    <Link href={appPath(`/services/${s.slug}`)} style={{ fontWeight: 700 }}>
                      Details
                    </Link>
                  </div>
                </div>
              </Card>
            );
          })}
        </div>
      </div>
    </MainLayout>
  );
}
