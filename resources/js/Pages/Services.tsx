import { Head, Link } from '@inertiajs/react';

import { appPath } from '@/lib/paths';
import {
  Activity,
  Ambulance,
  Bandage,
  Brain,
  Droplet,
  FlaskConical,
  HeartPulse,
  Stethoscope,
  Syringe,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';

import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import MainLayout from '@/Layouts/MainLayout';
import type { Service } from '@/types';

type Props = {
  services: Service[];
};

const SERVICE_ICONS: Record<string, LucideIcon> = {
  'doctor-for-home-visit': Stethoscope,
  'sugar-check': Droplet,
  'dressing-wound-care': Bandage,
  'urgent-care-at-home': Ambulance,
  'iv-fluid-therapy': Syringe,
  'nursing-care': HeartPulse,
  'physiotherapy-at-home': Activity,
  'home-lab-testing': FlaskConical,
  'mental-health-support': Brain,
};

export default function Services({ services }: Props) {
  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
        <Head title="Doctor home visit services in Mumbai">
          <meta
            name="description"
            content="Home visit doctor, follow-up care, and elderly-focused visits in Mumbai. Transparent pricing and physician-led care."
          />
        </Head>
        <PageHeader title="Services in Mumbai" subtitle="Choose a service to learn how we support patients at home." />
        <div style={{ display: 'grid', gap: '1rem', gridTemplateColumns: 'repeat(auto-fill, minmax(260px, 1fr))' }}>
          {services.map((s) => {
            const Icon = SERVICE_ICONS[s.slug] ?? Stethoscope;
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
                      background: '#fff2f4',
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
