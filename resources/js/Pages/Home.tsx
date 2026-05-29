import { Head, Link, usePage } from '@inertiajs/react';

import { appPath } from '@/lib/paths';
import { serviceIcon } from '@/lib/serviceIcons';
import type { CSSProperties, ReactNode } from 'react';
import {
  Award,
  CalendarCheck,
  ClipboardCheck,
  MapPin,
  PhoneCall,
  Stethoscope,
  Users,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';

import { Card } from '@/Components/ui/Card';
import { ErrorAlert } from '@/Components/ui/ErrorAlert';
import { PageHeader } from '@/Components/ui/PageHeader';
import MainLayout from '@/Layouts/MainLayout';
import type { HomepageSection, Service, Site, SiteStat, SiteTestimonial } from '@/types';

type SiteHome = {
  stats: SiteStat[];
  testimonials: SiteTestimonial[];
};

type Props = {
  homepageSections?: HomepageSection[] | null;
  services?: Service[] | null;
  siteHome?: SiteHome | null;
};

function asSections(v: HomepageSection[] | null | undefined): HomepageSection[] {
  return Array.isArray(v) ? v : [];
}

function asServices(v: Service[] | null | undefined): Service[] {
  return Array.isArray(v) ? v : [];
}

const STAT_ICONS: LucideIcon[] = [Award, Stethoscope, Users, ClipboardCheck];

const iconCircle: CSSProperties = {
  width: 52,
  height: 52,
  borderRadius: '50%',
  display: 'grid',
  placeItems: 'center',
  background: '#f3eef8',
  color: 'var(--color-primary)',
  flexShrink: 0,
};

function ServiceIcon({ slug }: { slug: string }) {
  const Icon = serviceIcon(slug);
  return (
    <div style={iconCircle}>
      <Icon size={26} strokeWidth={2} aria-hidden />
    </div>
  );
}

export default function Home({ homepageSections, services, siteHome }: Props) {
  const sections = asSections(homepageSections);
  const svc = asServices(services);
  const { site } = usePage<{ site: Site | null }>().props;
  const stats: SiteStat[] = Array.isArray(siteHome?.stats) ? siteHome.stats : [];
  const testimonials = Array.isArray(siteHome?.testimonials) ? siteHome.testimonials : [];
  const phone = site?.phone;
  const siteName = site?.site_name ?? 'Satatva Health';

  if (!site) {
    return (
      <MainLayout>
        <div className="container" style={{ padding: '2rem 1.5rem' }}>
          <ErrorAlert title="Configuration" message="Site settings are missing. Run migrations and seed the database." />
        </div>
      </MainLayout>
    );
  }

  const renderSection = (section: HomepageSection): ReactNode => {
    if (section.section_key === 'hero') {
      return (
        <section key={section.id} className="section-red section-pad !m-0">
          <div className="container">
            <div className="grid items-center gap-8 md:grid-cols-2 md:gap-10">
              <div className="order-2 flex flex-col md:order-1">
                <h1 className="mb-3 mt-0 text-[clamp(1.75rem,4vw,2.35rem)] font-extrabold leading-tight text-white">
                  {section.heading ?? siteName}
                </h1>
                {section.subheading ? (
                  <p className="mb-4 max-w-[52ch] text-[1.08rem] leading-relaxed text-white/95">{section.subheading}</p>
                ) : null}
                {section.body ? (
                  <p className="mb-5 whitespace-pre-wrap text-base leading-relaxed text-white/90">{section.body}</p>
                ) : null}
                {phone ? (
                  <a
                    href={`tel:${phone.replace(/\s/g, '')}`}
                    className="inline-block w-full rounded-full bg-white px-6 py-3.5 text-center text-base font-extrabold text-primary no-underline shadow-md transition hover:bg-white/95 sm:w-auto"
                  >
                    Call to book consultation
                  </a>
                ) : null}
              </div>
              <div className="order-1 mx-auto w-full max-w-[420px] md:order-2 md:mx-0 md:justify-self-center">
                <img
                  src="/images/dr-anand/clinic-card.png"
                  alt="Dr. Anand S. Prajapati — Satatva Health, Satatv Clinic Kandivali West"
                  loading="eager"
                  className="block w-full rounded-brand shadow-[0_12px_40px_rgba(0,0,0,0.2)]"
                />
              </div>
            </div>
          </div>
        </section>
      );
    }

    if (section.section_key === 'how_it_works') {
      const steps = [
        { Icon: PhoneCall, title: 'Call to book', text: 'Share your symptoms and any reports — we schedule a clinic appointment at Satatv Clinic.' },
        { Icon: CalendarCheck, title: 'Consultation', text: 'Dr. Prajapati examines you, explains the diagnosis, and discusses treatment options clearly.' },
        { Icon: MapPin, title: 'Treatment at clinic', text: 'Procedures and surgery are performed at Satatv Clinic, Kandivali West — not at home.' },
        { Icon: ClipboardCheck, title: 'Follow-up care', text: 'Structured post-operative reviews until you recover fully.' },
      ];
      return (
        <section key={section.id} className="section-light section-pad">
          <div className="container">
            <PageHeader title={section.heading ?? 'How it works'} subtitle={section.subheading ?? undefined} />
            {section.body ? <p style={{ whiteSpace: 'pre-wrap', lineHeight: 1.65, maxWidth: '72ch', marginBottom: '1.5rem' }}>{section.body}</p> : null}
            <div style={{ display: 'grid', gap: '1.25rem', gridTemplateColumns: 'repeat(auto-fill, minmax(220px, 1fr))' }}>
              {steps.map((item) => {
                const StepIcon = item.Icon;
                return (
                  <Card key={item.title} as="div">
                    <div style={{ ...iconCircle, marginBottom: '0.75rem' }}>
                      <StepIcon size={24} strokeWidth={2} aria-hidden />
                    </div>
                    <h3 style={{ margin: '0 0 0.35rem', fontSize: '1.05rem' }}>{item.title}</h3>
                    <p style={{ margin: 0, color: 'var(--color-muted)', fontSize: '0.95rem', lineHeight: 1.55 }}>{item.text}</p>
                  </Card>
                );
              })}
            </div>
          </div>
        </section>
      );
    }

    if (section.section_key === 'capabilities') {
      return (
        <section key={section.id} className="section-white section-pad">
          <div className="container">
            <PageHeader title={section.heading ?? 'Conditions we treat'} subtitle={section.subheading ?? undefined} />
            <img
              src="/images/dr-anand/conditions-grid.png"
              alt="Conditions treated at Satatva Health — piles, fistula, hernia, and more"
              loading="lazy"
              style={{
                width: '100%',
                borderRadius: 'var(--radius)',
                marginBottom: '1.5rem',
                display: 'block',
                boxShadow: 'var(--shadow)',
              }}
            />
            {section.body ? <p style={{ whiteSpace: 'pre-wrap', lineHeight: 1.65 }}>{section.body}</p> : null}
          </div>
        </section>
      );
    }

    return (
      <section key={section.id} className="section-white section-pad">
        <div className="container">
          <Card>
            {section.image ? (
              <img
                src={section.image}
                alt={section.heading ?? 'Homepage section'}
                loading="lazy"
                style={{
                  width: '100%',
                  maxHeight: 220,
                  objectFit: 'cover',
                  borderRadius: 'var(--radius)',
                  marginBottom: '1rem',
                  display: 'block',
                }}
              />
            ) : null}
            <PageHeader title={section.heading ?? section.section_key} subtitle={section.subheading ?? undefined} />
            {section.body ? <p style={{ whiteSpace: 'pre-wrap', lineHeight: 1.65 }}>{section.body}</p> : null}
          </Card>
        </div>
      </section>
    );
  };

  return (
    <MainLayout>
      <Head title={site.meta_title}>
        {site.meta_description ? <meta name="description" content={site.meta_description} /> : null}
      </Head>

      {sections.map(renderSection)}

      {stats.length > 0 ? (
        <section className="section-light section-pad">
          <div className="container">
            <PageHeader title={`${siteName} in numbers`} subtitle="Trusted surgical care at Satatv Clinic, Kandivali West." />
            <div style={{ display: 'grid', gap: '1rem', gridTemplateColumns: 'repeat(auto-fill, minmax(160px, 1fr))', marginTop: '1rem' }}>
              {stats.map((s, i) => {
                const Icon = STAT_ICONS[i % STAT_ICONS.length];
                return (
                  <div
                    key={s.label}
                    style={{
                      textAlign: 'center',
                      padding: '1.15rem 1rem',
                      borderRadius: 'var(--radius)',
                      background: 'var(--color-surface)',
                      border: '1px solid rgba(91, 45, 140, 0.12)',
                      boxShadow: 'var(--shadow)',
                    }}
                  >
                    <div style={{ display: 'flex', justifyContent: 'center', marginBottom: '0.5rem' }}>
                      <div style={iconCircle}>
                        <Icon size={24} strokeWidth={2} aria-hidden />
                      </div>
                    </div>
                    <div style={{ fontSize: '1.65rem', fontWeight: 800, color: 'var(--color-primary)' }}>{s.value}</div>
                    <div style={{ fontSize: '0.88rem', color: 'var(--color-muted)', marginTop: '0.35rem' }}>{s.label}</div>
                  </div>
                );
              })}
            </div>
          </div>
        </section>
      ) : null}

      {svc.length > 0 ? (
        <section className="section-white section-pad">
          <div className="container">
            <PageHeader title="Our services" subtitle="General and laser surgery at Satatv Clinic — book a consultation today." />
            <img
              src="/images/dr-anand/services-board.png"
              alt="Surgical services at Satatva Health"
              loading="lazy"
              style={{
                width: '100%',
                maxWidth: 480,
                borderRadius: 'var(--radius)',
                marginBottom: '1.5rem',
                display: 'block',
                boxShadow: 'var(--shadow)',
              }}
            />
            <div style={{ display: 'grid', gap: '1rem', gridTemplateColumns: 'repeat(auto-fill, minmax(260px, 1fr))' }}>
              {svc.map((s) => (
                <Card key={s.id} as="section">
                  <div style={{ display: 'flex', alignItems: 'flex-start', gap: '0.85rem' }}>
                    <ServiceIcon slug={s.slug} />
                    <div style={{ flex: 1, minWidth: 0 }}>
                      <h3 style={{ marginTop: 0 }}>{s.title}</h3>
                      <p style={{ color: 'var(--color-muted)' }}>{s.short_description}</p>
                      <Link href={appPath(`/services/${s.slug}`)} style={{ fontWeight: 700 }}>
                        Read more
                      </Link>
                    </div>
                  </div>
                </Card>
              ))}
            </div>
          </div>
        </section>
      ) : null}

      {testimonials.length > 0 ? (
        <section className="section-white section-pad">
          <div className="container">
            <h2 style={{ marginTop: 0, fontSize: 'clamp(1.35rem, 3vw, 1.75rem)', color: 'var(--color-primary)' }}>What our patients say</h2>
            <p style={{ color: 'var(--color-muted)', maxWidth: '60ch', marginBottom: '1.5rem' }}>Trusted surgical care at Satatv Clinic, Kandivali West.</p>
            <div style={{ display: 'grid', gap: '1rem', gridTemplateColumns: 'repeat(auto-fill, minmax(280px, 1fr))' }}>
              {testimonials.slice(0, 5).map((t, i) => (
                <blockquote
                  key={`${t.name}-${i}`}
                  style={{
                    margin: 0,
                    padding: '1.1rem 1.15rem',
                    borderRadius: 'var(--radius)',
                    background: 'var(--color-surface)',
                    border: '1px solid rgba(91, 45, 140, 0.12)',
                    boxShadow: 'var(--shadow)',
                  }}
                >
                  <p style={{ margin: 0, lineHeight: 1.55 }}>&ldquo;{t.quote}&rdquo;</p>
                  <footer style={{ marginTop: '0.65rem', fontWeight: 700, color: 'var(--color-primary)' }}>— {t.name}</footer>
                </blockquote>
              ))}
            </div>
          </div>
        </section>
      ) : null}

      <section className="section-light section-pad">
        <div className="container" style={{ textAlign: 'center' }}>
          <p style={{ margin: '0 0 0.75rem', color: 'var(--color-muted)' }}>Questions about surgery, appointments, or recovery?</p>
          <Link href="/faqs" style={{ fontWeight: 700, marginRight: '1.25rem' }}>
            Read FAQs
          </Link>
          <Link href={appPath('/contact')} style={{ fontWeight: 700 }}>
            Contact us
          </Link>
        </div>
      </section>
    </MainLayout>
  );
}
