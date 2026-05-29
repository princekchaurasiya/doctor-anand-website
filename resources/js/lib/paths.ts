/** Repo subpath on GitHub Pages, e.g. /doconnect-react-website (empty locally). */
const appBase = (import.meta.env.VITE_APP_BASE_PATH as string) || '';

/**
 * Prefix internal app routes for GitHub Pages project sites.
 * Root-relative paths like /services resolve to github.io/services without this.
 */
export function appPath(path: string): string {
  const normalized = path.startsWith('/') ? path : `/${path}`;
  if (!appBase) {
    return normalized;
  }

  const base = appBase.replace(/\/$/, '');
  if (normalized === base || normalized.startsWith(`${base}/`)) {
    return normalized;
  }

  return normalized === '/' ? `${base}/` : `${base}${normalized}`;
}

export function stripAppBase(path: string): string {
  if (!appBase || !path.startsWith(appBase)) {
    return path;
  }

  const stripped = path.slice(appBase.length);

  return stripped === '' ? '/' : stripped;
}
