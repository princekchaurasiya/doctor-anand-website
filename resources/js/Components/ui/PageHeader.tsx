import type { CSSProperties, ReactNode } from 'react';

type Props = {
  title: string;
  subtitle?: string;
  children?: ReactNode;
  style?: CSSProperties;
};

export function PageHeader({ title, subtitle, children, style }: Props) {
  return (
    <header style={{ marginBottom: '1.5rem', ...style }}>
      <h1 style={{ margin: 0, fontSize: '1.75rem', color: 'var(--color-primary-dark)' }}>{title}</h1>
      {subtitle && <p style={{ margin: '0.35rem 0 0', color: 'var(--color-muted)', maxWidth: '52ch' }}>{subtitle}</p>}
      {children}
    </header>
  );
}
