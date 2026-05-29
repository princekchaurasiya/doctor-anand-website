import { Link, usePage } from '@inertiajs/react';

import { appPath } from '@/lib/paths';
import { Clock, Mail, Phone } from 'lucide-react';

import type { Site } from '@/types';

const link = { color: '#ffc9d0', textDecoration: 'none' as const };

export function SiteFooter() {
  const { site } = usePage<{ site: Site | null }>().props;
  const phone = site?.phone ?? null;
  const email = site?.email ?? null;
  const siteName = site?.site_name ?? 'Doconnect';

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
            <p style={{ margin: '0.5rem 0 0', maxWidth: '42ch', color: '#f3d1d6', lineHeight: 1.55 }}>
              At {siteName}, our priority is comprehensive, quality care at home in Mumbai. From doctor consultations and nebulisation to
              injections, wound care, and nursing—we help families get the right support when travel to a clinic is difficult.
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
            <ul style={{ listStyle: 'none', padding: 0, margin: '0.5rem 0 0', color: '#f3d1d6' }}>
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
              {site?.open_hours ? (
                <li style={{ display: 'flex', alignItems: 'flex-start', gap: '0.45rem', marginTop: '0.35rem' }}>
                  <Clock size={18} style={{ flexShrink: 0, marginTop: 2 }} aria-hidden />
                  <span>Hours: {site.open_hours}</span>
                </li>
              ) : null}
              <li style={{ marginTop: '0.65rem' }}>
                <Link href={appPath('/contact')} style={link}>
                  Request a callback
                </Link>
              </li>
            </ul>
          </div>
        </div>
        <p style={{ textAlign: 'center', margin: '2rem 0 0', fontSize: '0.85rem', color: '#e8aeb5' }}>
          © {new Date().getFullYear()} {siteName}. All rights reserved.
        </p>
      </div>
    </footer>
  );
}
