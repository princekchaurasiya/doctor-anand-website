import type { CSSProperties, ReactNode } from 'react';

type Props = {
  children: ReactNode;
  gap?: string;
  style?: CSSProperties;
};

export function Stack({ children, gap = '1rem', style }: Props) {
  return (
    <div
      style={{
        display: 'flex',
        flexDirection: 'column',
        gap,
        ...style,
      }}
    >
      {children}
    </div>
  );
}
