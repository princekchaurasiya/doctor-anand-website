import { ChevronRight, CircleHelp, ListTree, Sparkles } from 'lucide-react';
import { useCallback, useEffect, useRef, useState } from 'react';

type Props = {
  items: string[];
  slugify: (text: string, index: number) => string;
};

const SCROLL_OFFSET = 100;

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

function indexFromHash(items: string[], slugify: (text: string, index: number) => string): number | null {
  const hash = window.location.hash.replace(/^#/, '');
  if (!hash) {
    return null;
  }
  const idx = items.findIndex((text, i) => slugify(text, i) === hash);
  return idx >= 0 ? idx : null;
}

export function BlogTableOfContents({ items, slugify }: Props) {
  const [activeIndex, setActiveIndex] = useState(0);
  const scrollLockUntilRef = useRef(0);

  const headingElements = useCallback((): HTMLElement[] => {
    return items
      .map((text, i) => document.getElementById(slugify(text, i)))
      .filter((el): el is HTMLElement => el !== null);
  }, [items, slugify]);

  const updateActiveFromScroll = useCallback(() => {
    const headings = headingElements();
    if (headings.length === 0) {
      return;
    }

    const scrollPosition = window.scrollY + SCROLL_OFFSET;
    let next = 0;

    for (let i = 0; i < headings.length; i++) {
      if (headings[i].offsetTop <= scrollPosition) {
        next = i;
      }
    }

    setActiveIndex(next);
  }, [headingElements]);

  useEffect(() => {
    const fromHash = indexFromHash(items, slugify);
    if (fromHash !== null) {
      setActiveIndex(fromHash);
    }

    const onScroll = () => updateActiveFromScroll();
    const onHashChange = () => {
      const idx = indexFromHash(items, slugify);
      if (idx !== null) {
        setActiveIndex(idx);
      }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('hashchange', onHashChange);
    updateActiveFromScroll();

    return () => {
      window.removeEventListener('scroll', onScroll);
      window.removeEventListener('hashchange', onHashChange);
    };
  }, [items, slugify, updateActiveFromScroll]);

  function scrollToSection(index: number) {
    const id = slugify(items[index], index);
    const el = document.getElementById(id);
    if (!el) {
      return;
    }

    scrollLockUntilRef.current = Date.now() + 900;
    setActiveIndex(index);
    window.history.replaceState(null, '', `#${id}`);
    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

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
              <a
                href={`#${slugify(item, i)}`}
                className="blog-toc-link"
                aria-current={isActive ? 'location' : undefined}
                onClick={(e) => {
                  e.preventDefault();
                  scrollToSection(i);
                }}
              >
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
