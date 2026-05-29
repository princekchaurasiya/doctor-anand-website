import { Stack } from '@/Components/ui/Stack';

type Props = {
  title: string;
  message: string;
  fieldErrors?: Record<string, string[]>;
};

export function ErrorAlert({ title, message, fieldErrors }: Props) {
  return (
    <div
      role="alert"
      style={{
        border: '1px solid #c62828',
        background: '#ffebee',
        color: '#b71c1c',
        borderRadius: 'var(--radius)',
        padding: '1rem',
      }}
    >
      <strong>{title}</strong>
      <p style={{ margin: '0.35rem 0 0' }}>{message}</p>
      {fieldErrors && (
        <Stack gap="0.35rem" style={{ marginTop: '0.75rem' }}>
          {Object.entries(fieldErrors).map(([field, msgs]) => (
            <div key={field}>
              <strong>{field}</strong>: {msgs.join(', ')}
            </div>
          ))}
        </Stack>
      )}
    </div>
  );
}
