import { Head } from '@inertiajs/react';

import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import { Stack } from '@/Components/ui/Stack';
import MainLayout from '@/Layouts/MainLayout';

export default function About() {
  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
      <Head title="About Doconnect | Doctor home visits in Mumbai" />
      <PageHeader title="About us" subtitle="Healthcare that comes to you—across Mumbai." />
      <Stack gap="1.25rem">
        <Card as="section">
          <h2 style={{ marginTop: 0 }}>Welcome to Doconnect</h2>
          <p style={{ color: 'var(--color-muted)', lineHeight: 1.65 }}>
            We bring accessible, quality medical care through doctor-for-home-visit services. Whether you are managing chronic illness,
            recovering from surgery, or need a routine check-up, our clinicians help you avoid long queues and travel—so you get attention
            in the comfort of your home.
          </p>
        </Card>
        <Card as="section">
          <h2 style={{ marginTop: 0 }}>How Doconnect works</h2>
          <p style={{ lineHeight: 1.65 }}>
            Our doctor on call for home visit service connects you with a highly trained team. Many of our doctors have hospital experience,
            including caring for critically ill patients. They focus on accurate assessment at home, clear diagnosis where appropriate, and
            treatment plans that improve outcomes—always with escalation to hospital teams when required.
          </p>
          <p style={{ lineHeight: 1.65 }}>
            Call to schedule a visit; we coordinate timing, equipment, and follow-up. We provide continuous care management for ongoing
            needs so recovery stays on track.
          </p>
        </Card>
        <Card as="section">
          <h2 style={{ marginTop: 0 }}>What we can support at home</h2>
          <p style={{ marginBottom: '0.75rem' }}>Examples of services families often book with us include:</p>
          <ul style={{ lineHeight: 1.7, margin: 0, paddingLeft: '1.25rem' }}>
            <li>Nebulisation</li>
            <li>Sugar (blood glucose) checks</li>
            <li>Injection administration</li>
            <li>Dressing and wound care</li>
            <li>Management of severe abdominal pain (assessment and referral as needed)</li>
            <li>Relief pathways for shivering and fever</li>
            <li>Treatment planning for high-grade fever</li>
            <li>IV fluid therapy when prescribed</li>
            <li>Small stitches when suitable for home</li>
            <li>Urethral catheterisation when clinically indicated</li>
            <li>Consultation at home</li>
          </ul>
          <p style={{ marginTop: '1rem', color: 'var(--color-muted)', fontSize: '0.95rem' }}>
            Scope depends on clinical assessment, safety, and your treating doctor&apos;s plan. Emergency symptoms always belong in the
            emergency department—our team will guide you clearly.
          </p>
        </Card>
      </Stack>
      </div>
    </MainLayout>
  );
}
