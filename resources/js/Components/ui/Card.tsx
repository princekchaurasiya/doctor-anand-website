import type { CSSProperties, ReactNode } from 'react';

type Props = {
  children: ReactNode;
  style?: CSSProperties;
  as?: 'article' | 'section' | 'div' | 'blockquote';
};

export function Card({ children, style, as: Tag = 'article' }: Props) {
  return (
    <Tag
      style={{
        background: 'var(--color-surface)',
        borderRadius: 'var(--radius)',
        boxShadow: 'var(--shadow)',
        padding: '1.25rem 1.5rem',
        ...style,
      }}
    >
      {children}
    </Tag>
  );
}
