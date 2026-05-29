import type { ButtonHTMLAttributes, CSSProperties, ReactNode } from 'react';

type Props = ButtonHTMLAttributes<HTMLButtonElement> & {
  variant?: 'primary' | 'ghost' | 'outline';
  children: ReactNode;
};

const variants: Record<NonNullable<Props['variant']>, CSSProperties> = {
  primary: {
    fontWeight: 600,
    cursor: 'pointer',
    borderRadius: 'var(--radius)',
    fontSize: '1rem',
    background: 'var(--color-primary)',
    color: '#fff',
    border: 'none',
    padding: '0.65rem 1.25rem',
  },
  ghost: {
    fontWeight: 600,
    cursor: 'pointer',
    borderRadius: 'var(--radius)',
    fontSize: '1rem',
    background: 'transparent',
    color: 'var(--color-primary)',
    border: 'none',
    padding: '0.65rem 1rem',
  },
  outline: {
    fontWeight: 600,
    cursor: 'pointer',
    borderRadius: 'var(--radius)',
    fontSize: '1rem',
    background: 'transparent',
    color: 'var(--color-primary)',
    border: '2px solid var(--color-primary)',
    padding: '0.55rem 1.15rem',
  },
};

export function Button({ variant = 'primary', type = 'button', style, children, ...rest }: Props) {
  return (
    <button type={type} style={{ ...variants[variant], ...style }} {...rest}>
      {children}
    </button>
  );
}
