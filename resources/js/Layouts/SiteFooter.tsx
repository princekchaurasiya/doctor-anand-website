import { Link, usePage } from '@inertiajs/react';

import { appPath } from '@/lib/paths';
import { Clock, Mail, MapPin, Phone } from 'lucide-react';

import type { Site } from '@/types';

const link = { color: '#e8d4f5', textDecoration: 'none' as const };

export function SiteFooter() {
  const { site } = usePage<{ site: Site | null }>().props;
  const phone = site?.phone ?? null;
  const email = site?.email ?? null;
  const siteName = site?.site_name ?? 'Satatva Health';

  return (
    <footer className="section-dark" style={{ marginTop: 0, padding: '2.75rem 0 1.5rem' }}>
      <div className="container">
        <div
          style={{
            display: 'grid',
            gap: '2rem',
            gridTemplateColumns: 'repeat(auto-fill, minmax(220px, 1fr))',
          }}
        >
          <div>
            <strong style={{ fontSize: '1.05rem' }}>{siteName}</strong>
            <p style={{ margin: '0.5rem 0 0', maxWidth: '42ch', color: '#e8d4f5', lineHeight: 1.55 }}>
              Surgical care by Dr. Anand S. Prajapati, M.S. — General Surgeon, Ano-Proctologist &amp; Laser Surgeon at Satatv Clinic
              (सातत्व क्लिनिक), Kandivali West, Mumbai. Clinic-based care only — not home visits.
            </p>
          </div>
          <div>
            <strong style={{ fontSize: '1.05rem' }}>Useful links</strong>
            <ul style={{ listStyle: 'none', padding: 0, margin: '0.5rem 0 0', lineHeight: 1.9 }}>
              <li>
                <Link href={appPath('/')} style={link}>
                  Home
                </Link>
              </li>
              <li>
                <Link href={appPath('/about')} style={link}>
                  About us
                </Link>
              </li>
              <li>
                <Link href={appPath('/services')} style={link}>
                  Services
                </Link>
              </li>
              <li>
                <Link href={appPath('/testimonials')} style={link}>
                  Testimonials
                </Link>
              </li>
              <li>
                <Link href={appPath('/faqs')} style={link}>
                  FAQs
                </Link>
              </li>
              <li>
                <Link href={appPath('/blog')} style={link}>
                  Blogs
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <strong style={{ fontSize: '1.05rem' }}>Contact</strong>
            <ul style={{ listStyle: 'none', padding: 0, margin: '0.5rem 0 0', color: '#e8d4f5' }}>
              {phone && (
                <li style={{ display: 'flex', alignItems: 'center', gap: '0.45rem', marginBottom: '0.35rem' }}>
                  <Phone size={18} aria-hidden />
                  <a href={`tel:${phone.replace(/\s/g, '')}`} style={{ color: '#fff', fontWeight: 600 }}>
                    {phone}
                  </a>
                </li>
              )}
              {email && (
                <li style={{ display: 'flex', alignItems: 'center', gap: '0.45rem', marginBottom: '0.35rem' }}>
                  <Mail size={18} aria-hidden />
                  <a href={`mailto:${email}`} style={{ color: '#fff', fontWeight: 600 }}>
                    {email}
                  </a>
                </li>
              )}
              {site?.address_line ? (
                <li style={{ display: 'flex', alignItems: 'flex-start', gap: '0.45rem', marginTop: '0.35rem' }}>
                  <MapPin size={18} style={{ flexShrink: 0, marginTop: 2 }} aria-hidden />
                  <span>{site.address_line}</span>
                </li>
              ) : null}
              {site?.open_hours ? (
                <li style={{ display: 'flex', alignItems: 'flex-start', gap: '0.45rem', marginTop: '0.35rem' }}>
                  <Clock size={18} style={{ flexShrink: 0, marginTop: 2 }} aria-hidden />
                  <span>Hours: {site.open_hours}</span>
                </li>
              ) : null}
              <li style={{ marginTop: '0.65rem' }}>
                <Link href={appPath('/contact')} style={link}>
                  Request an appointment
                </Link>
              </li>
            </ul>
          </div>
        </div>
        <p style={{ textAlign: 'center', margin: '2rem 0 0', fontSize: '0.85rem', color: '#d4b8e8' }}>
          © {new Date().getFullYear()} {siteName}. All rights reserved.
        </p>
      </div>
    </footer>
  );
}
