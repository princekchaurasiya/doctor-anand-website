export function Spinner({ label = 'Loading' }: { label?: string }) {
  return (
    <p style={{ color: 'var(--color-muted)' }} role="status" aria-live="polite">
      {label}…
    </p>
  );
}
