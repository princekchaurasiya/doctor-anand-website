import { Head } from '@inertiajs/react';

import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import { Stack } from '@/Components/ui/Stack';
import MainLayout from '@/Layouts/MainLayout';

export default function About() {
  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
        <Head title="About Satatva Health | Dr. Anand S. Prajapati, Kandivali West">
          <meta
            name="description"
            content="Satatva Health is the surgical practice of Dr. Anand S. Prajapati, M.S. — General Surgeon, Ano-Proctologist & Laser Surgeon at Satatv Clinic, Mumbai."
          />
        </Head>
        <PageHeader title="About us" subtitle="Expert surgical care at Satatv Clinic, Kandivali West." />
        <Stack gap="1.25rem">
          <Card as="section">
            <h2 style={{ marginTop: 0 }}>Welcome to Satatva Health</h2>
            <p style={{ color: 'var(--color-muted)', lineHeight: 1.65 }}>
              Satatva Health is the practice of <strong>Dr. Anand S. Prajapati</strong>, M.S. (General Surgeon), Consultant
              Ano-Proctologist &amp; Laser Surgeon, at <strong>Satatv Clinic</strong> (सातत्व क्लिनिक) in Kandivali West, Mumbai.
            </p>
            <p style={{ color: 'var(--color-muted)', lineHeight: 1.65, marginBottom: 0 }}>
              We provide clinic-based surgical care — not home visits. Every patient receives a thorough evaluation, clear explanation
              of treatment options, and dedicated follow-up through recovery.
            </p>
          </Card>
          <Card as="section">
            <h2 style={{ marginTop: 0 }}>About Dr. Anand S. Prajapati</h2>
            <p style={{ lineHeight: 1.65 }}>
              Dr. Prajapati specialises in proctology, laser surgery, and general surgical procedures. With extensive experience in
              piles, fistula, fissure, hernia, gallbladder, hydrocele, and soft-tissue surgery, he combines modern minimally invasive
              techniques with patient-centred communication.
            </p>
            <p style={{ lineHeight: 1.65, marginBottom: 0 }}>
              All consultations and procedures take place at Satatv Clinic — Goyal Aspire, 104, 1st Floor, Near Atul Tower,
              Mathuradas Ext Road, Kandivali West, Mumbai — 400 067.
            </p>
          </Card>
          <Card as="section">
            <h2 style={{ marginTop: 0 }}>Conditions we treat</h2>
            <p style={{ marginBottom: '0.75rem' }}>Services available at Satatv Clinic include:</p>
            <ul style={{ lineHeight: 1.7, margin: 0, paddingLeft: '1.25rem' }}>
              <li>Piles — laser and minimally invasive treatment</li>
              <li>Anal fissure and fistula</li>
              <li>Pilonidal sinus</li>
              <li>Gallbladder stones (laparoscopic surgery)</li>
              <li>Hernia repair</li>
              <li>Hydrocele and varicocele</li>
              <li>Phimosis and circumcision</li>
              <li>Appendix surgery</li>
              <li>Lipoma and sebaceous cyst removal</li>
              <li>Abscess drainage</li>
              <li>Diabetic foot care</li>
              <li>Varicose vein treatment</li>
              <li>GERD / acidity evaluation</li>
              <li>Constipation assessment</li>
              <li>Fibroadenoma removal</li>
            </ul>
          </Card>
        </Stack>
      </div>
    </MainLayout>
  );
}
