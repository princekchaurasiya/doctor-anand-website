import type { CSSProperties, FormEvent } from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';

import { Button } from '@/Components/ui/Button';
import { Card } from '@/Components/ui/Card';
import { PageHeader } from '@/Components/ui/PageHeader';
import { Stack } from '@/Components/ui/Stack';
import MainLayout from '@/Layouts/MainLayout';
import type { Site } from '@/types';

const field: CSSProperties = {
  display: 'flex',
  flexDirection: 'column',
  gap: '0.35rem',
};

const input: CSSProperties = {
  padding: '0.55rem 0.65rem',
  borderRadius: 8,
  border: '1px solid rgba(91, 45, 140, 0.22)',
  fontSize: '1rem',
};

export default function Contact() {
  const { site, status } = usePage<{ site: Site | null; status?: string | null }>().props;
  const phone = site?.phone ?? null;

  const form = useForm({
    name: '',
    phone: '',
    email: '',
    message: '',
  });

  function submit(e: FormEvent) {
    e.preventDefault();
    form.post('/contact', {
      preserveScroll: true,
      onSuccess: () => form.reset(),
    });
  }

  const err = (key: string) => {
    const v = form.errors[key as keyof typeof form.errors];
    return v ? String(v) : null;
  };

  const mapKey = import.meta.env.VITE_GOOGLE_MAPS_EMBED_KEY as string | undefined;
  const clinicAddress =
    site?.address_line ??
    'Goyal Aspire, 104, 1st Floor, Near Atul Tower, Mathuradas Ext Road, Kandivali West, Mumbai — 400 067';

  return (
    <MainLayout>
      <div className="container" style={{ padding: '1.5rem 1.25rem 3rem' }}>
        <Head title="Contact | Satatva Health — Satatv Clinic Kandivali">
          <meta name="description" content="Book a consultation with Dr. Anand S. Prajapati at Satatv Clinic, Kandivali West, Mumbai." />
        </Head>
        <PageHeader
          title="Contact"
          subtitle="Book a clinic appointment at Satatv Clinic. For emergencies, call directly or visit the nearest hospital."
        />
        {phone && (
          <p style={{ marginTop: 0 }}>
            <a href={`tel:${phone.replace(/\s/g, '')}`} style={{ fontWeight: 700, fontSize: '1.1rem' }}>
              {phone}
            </a>
          </p>
        )}
        {site?.email ? (
          <p style={{ marginTop: '0.35rem' }}>
            <a href={`mailto:${site.email}`} style={{ fontWeight: 600 }}>
              {site.email}
            </a>
          </p>
        ) : null}
        <p style={{ color: 'var(--color-muted)', lineHeight: 1.6, maxWidth: '60ch' }}>{clinicAddress}</p>
        <Card as="section" style={{ marginTop: '1.25rem' }}>
          <form onSubmit={submit}>
            <Stack gap="1rem">
              {status && (
                <p style={{ margin: 0, color: 'var(--color-primary)', fontWeight: 600 }} role="status">
                  {status}
                </p>
              )}
              <div style={field}>
                <label htmlFor="name">Name</label>
                <input id="name" value={form.data.name} onChange={(ev) => form.setData('name', ev.target.value)} style={input} />
                {err('name') && <span style={{ color: '#b71c1c', fontSize: '0.85rem' }}>{err('name')}</span>}
              </div>
              <div style={field}>
                <label htmlFor="phone">Mobile</label>
                <input id="phone" value={form.data.phone} onChange={(ev) => form.setData('phone', ev.target.value)} style={input} />
                {err('phone') && <span style={{ color: '#b71c1c', fontSize: '0.85rem' }}>{err('phone')}</span>}
              </div>
              <div style={field}>
                <label htmlFor="email">Email (optional)</label>
                <input id="email" type="email" value={form.data.email} onChange={(ev) => form.setData('email', ev.target.value)} style={input} />
                {err('email') && <span style={{ color: '#b71c1c', fontSize: '0.85rem' }}>{err('email')}</span>}
              </div>
              <div style={field}>
                <label htmlFor="message">Message (optional)</label>
                <textarea id="message" rows={4} value={form.data.message} onChange={(ev) => form.setData('message', ev.target.value)} style={input} />
                {err('message') && <span style={{ color: '#b71c1c', fontSize: '0.85rem' }}>{err('message')}</span>}
              </div>
              <Button type="submit" disabled={form.processing}>
                {form.processing ? 'Sending…' : 'Request an appointment'}
              </Button>
            </Stack>
          </form>
        </Card>
        {mapKey ? (
          <section style={{ marginTop: '2rem' }}>
            <h2 style={{ fontSize: '1.15rem', color: 'var(--color-primary)' }}>Clinic location</h2>
            <p style={{ color: 'var(--color-muted)', marginBottom: '0.75rem' }}>Satatv Clinic, Kandivali West, Mumbai.</p>
            <div style={{ borderRadius: 'var(--radius)', overflow: 'hidden', border: '1px solid rgba(91, 45, 140, 0.15)' }}>
              <iframe
                title="Satatv Clinic location map"
                width="100%"
                height="320"
                style={{ border: 0, display: 'block' }}
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                src={`https://www.google.com/maps/embed/v1/place?key=${encodeURIComponent(mapKey)}&q=${encodeURIComponent('Goyal Aspire Kandivali West Mumbai')}`}
              />
            </div>
          </section>
        ) : null}
      </div>
    </MainLayout>
  );
}
