import { ChevronRight, CircleHelp, ListTree, Sparkles } from 'lucide-react';
import { useEffect, useState } from 'react';

type Props = {
  items: string[];
  slugify: (text: string, index: number) => string;
};

function tocIcon(label: string) {
  const lower = label.toLowerCase();
  if (lower.includes('faq') || lower.includes('frequently asked')) {
    return CircleHelp;
  }
  if (lower.includes('conclusion') || lower.includes('final')) {
    return Sparkles;
  }
  return ChevronRight;
}

export function BlogTableOfContents({ items, slugify }: Props) {
  const [activeIndex, setActiveIndex] = useState(0);

  useEffect(() => {
    const ids = items.map((text, i) => slugify(text, i));
    const headings = ids.map((id) => document.getElementById(id)).filter((el): el is HTMLElement => el !== null);
    if (headings.length === 0) {
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        const visible = entries
          .filter((e) => e.isIntersecting)
          .sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top);
        if (visible.length > 0) {
          const idx = headings.indexOf(visible[0].target as HTMLElement);
          if (idx >= 0) {
            setActiveIndex(idx);
          }
        }
      },
      { rootMargin: '-15% 0px -65% 0px', threshold: 0 }
    );

    headings.forEach((h) => observer.observe(h));

    return () => observer.disconnect();
  }, [items, slugify]);

  return (
    <nav aria-label="Table of contents" className="blog-toc-sidebar">
      <div className="blog-toc-header">
        <span className="blog-toc-header-icon" aria-hidden>
          <ListTree size={22} strokeWidth={2} />
        </span>
        <div>
          <p className="blog-toc-title">On this page</p>
          <p className="blog-toc-meta">
            {items.length} {items.length === 1 ? 'section' : 'sections'}
          </p>
        </div>
      </div>

      <ol className="blog-toc-list">
        {items.map((item, i) => {
          const Icon = tocIcon(item);
          const isActive = activeIndex === i;

          return (
            <li key={`${item}-${i}`} className={isActive ? 'blog-toc-item is-active' : 'blog-toc-item'}>
              <a href={`#${slugify(item, i)}`} className="blog-toc-link">
                <span className="blog-toc-num" aria-hidden>
                  {i + 1}
                </span>
                <span className="blog-toc-label">{item}</span>
                <span className="blog-toc-chevron" aria-hidden>
                  <Icon size={16} strokeWidth={2.25} />
                </span>
              </a>
            </li>
          );
        })}
      </ol>
    </nav>
  );
}
