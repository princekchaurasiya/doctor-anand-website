export type SiteStat = {
  label: string;
  value: string;
};

export type SiteTestimonial = {
  name: string;
  quote: string;
};

export type SiteFaq = {
  question: string;
  answer: string;
};

export type Site = {
  site_name: string;
  tagline: string | null;
  meta_title: string;
  meta_description: string | null;
  phone: string;
  whatsapp: string | null;
  email: string | null;
  address_line: string | null;
  service_areas: string | null;
  frontend_public_url: string | null;
  open_hours: string | null;
  stats: SiteStat[];
  testimonials: SiteTestimonial[];
  faqs: SiteFaq[];
  images: { og: string | null };
  json_ld: Record<string, unknown>;
};

export type HomepageSection = {
  id: number;
  section_key: string;
  heading: string | null;
  subheading: string | null;
  body: string | null;
  sort_order: number;
  image: string | null;
};

export type Service = {
  id: number;
  title: string;
  slug: string;
  short_description: string;
  body: string | null;
  sort_order: number;
  image: string | null;
};

export type BlogFaqItem = {
  question: string;
  answer: string;
};

export type BlogPostSummary = {
  id: number;
  title: string;
  slug: string;
  category: string | null;
  excerpt: string | null;
  published_at: string | null;
  image: string | null;
  tags: string[];
};

export type BlogPost = BlogPostSummary & {
  body: string;
  meta_title: string | null;
  meta_description: string | null;
  focus_keyword: string | null;
  faq_schema: BlogFaqItem[];
  table_of_contents: string[];
};

export type PaginationMeta = {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
};
