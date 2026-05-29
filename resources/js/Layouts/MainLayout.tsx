import type { ReactNode } from 'react';

import { SiteFooter } from '@/Layouts/SiteFooter';
import { SiteHeader } from '@/Layouts/SiteHeader';

type Props = {
  children: ReactNode;
};

export default function MainLayout({ children }: Props) {
  return (
    <>
      <SiteHeader />
      <main style={{ minHeight: '60vh' }}>{children}</main>
      <SiteFooter />
    </>
  );
}
