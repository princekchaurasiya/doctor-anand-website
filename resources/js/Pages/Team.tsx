import { Head, Link } from '@inertiajs/react';

import { appPath } from '@/lib/paths';

import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import MainLayout from '@/Layouts/MainLayout';

export default function Team() {
  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
        <Head title="Our team | Satatva Health">
          <meta
            name="description"
            content="Meet Dr. Anand S. Prajapati — M.S. General Surgeon, Ano-Proctologist & Laser Surgeon at Satatv Clinic, Kandivali West."
          />
        </Head>
        <PageHeader title="Our team" subtitle="Expert surgical care at Satatv Clinic, Kandivali West." />
        <Card as="article">
          <h2 style={{ marginTop: 0, color: 'var(--color-primary)' }}>Dr. Anand S. Prajapati</h2>
          <p style={{ fontWeight: 600, marginTop: 0 }}>M.S. (General Surgeon) · Consultant Ano-Proctologist &amp; Laser Surgeon</p>
          <p style={{ lineHeight: 1.65 }}>
            Dr. Anand S. Prajapati leads Satatva Health at Satatv Clinic (सातत्व क्लिनिक), Kandivali West, Mumbai. He specialises
            in proctology, laser surgery, and general surgical procedures including piles, fistula, fissure, hernia, gallbladder stones,
            hydrocele, and soft-tissue surgery.
          </p>
          <p style={{ lineHeight: 1.65 }}>
            Patients receive clear diagnosis, honest treatment recommendations, and structured follow-up through every stage of care.
            All consultations and procedures are performed at the clinic — not as home visits.
          </p>
          <p style={{ marginTop: '1.25rem' }}>
            <Link href={appPath('/contact')} style={{ fontWeight: 600 }}>
              Book a consultation
            </Link>{' '}
            or call the number in the header.
          </p>
        </Card>
      </div>
    </MainLayout>
  );
}
