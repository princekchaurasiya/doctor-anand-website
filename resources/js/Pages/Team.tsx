import { Head, Link } from '@inertiajs/react';

import { appPath } from '@/lib/paths';

import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import MainLayout from '@/Layouts/MainLayout';

export default function Team() {
  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
      <Head title="Our team | Doconnect" />
      <PageHeader title="Our team" subtitle="Hospital-trained doctors supporting care at home in Mumbai." />
      <Card as="article">
        <p style={{ lineHeight: 1.65 }}>
          Doconnect clinicians combine community-based visits with experience from acute and critical care settings. Our doctors are
          comfortable troubleshooting in the home environment, ordering tests when needed, and coordinating with hospital-based teams for
          admissions or specialist input.
        </p>
        <p style={{ lineHeight: 1.65 }}>
          We emphasise communication with families, transparent expectations, and follow-up after each visit. For detailed profiles and
          availability, please call our desk—we will match you to the right clinician for your case.
        </p>
        <p style={{ marginTop: '1.25rem' }}>
          <Link href={appPath('/contact')} style={{ fontWeight: 600 }}>
            Contact us
          </Link>{' '}
          or call the number in the header to speak with our team.
        </p>
      </Card>
      </div>
    </MainLayout>
  );
}
