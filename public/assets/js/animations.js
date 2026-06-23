(function () {
  if (typeof gsap === 'undefined') return;

  gsap.registerPlugin(ScrollTrigger);

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (reduceMotion) {
    // Skip all motion, just reveal everything instantly
    gsap.set('.reveal, .cat-card, .hc-card, .product-card', { opacity: 1, y: 0, scale: 1 });
    return;
  }

  // ============ HERO ENTRANCE ============
  function initHero() {
    const hero = document.getElementById('hero');
    if (!hero) return;

    const bgImg = hero.querySelector('.hero-bg-img');
    const labelRow = hero.querySelector('.hero-label-row');
    const title = hero.querySelector('.hero-title');
    const divider = hero.querySelector('.hero-gold-divider');
    const text = hero.querySelector('.hero-text');
    const btns = hero.querySelector('.hero-btns');
    const scrollInd = hero.querySelector('.scroll-indicator');

    // Kill the old CSS keyframe animations so GSAP fully controls timing
    [labelRow, title, text, btns].forEach(el => {
      if (el) el.style.animation = 'none';
    });

    // Background: starts slightly zoomed in, eases out — cinematic settle
    if (bgImg) {
      gsap.fromTo(bgImg,
        { scale: 1.12 },
        { scale: 1, duration: 2.2, ease: 'power2.out' }
      );
    }

    // Text entrance timeline — tighter choreography than independent CSS delays
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

    tl.fromTo(labelRow, { opacity: 0, y: 16 }, { opacity: 1, y: 0, duration: 0.7 }, 0.2)
      .fromTo(title, { opacity: 0, y: 28 }, { opacity: 1, y: 0, duration: 0.9 }, 0.35)
      .fromTo(divider, { opacity: 0, scaleX: 0 }, { opacity: 1, scaleX: 1, duration: 0.6 }, 0.75)
      .fromTo(text, { opacity: 0, y: 16 }, { opacity: 1, y: 0, duration: 0.7 }, 0.85)
      .fromTo(btns, { opacity: 0, y: 16 }, { opacity: 1, y: 0, duration: 0.7 }, 1.0)
      .fromTo(scrollInd, { opacity: 0 }, { opacity: 1, duration: 0.6 }, 1.4);

    // Slow parallax drift on hero background as user scrolls past it
    if (bgImg) {
      gsap.to(bgImg, {
        yPercent: 12,
        ease: 'none',
        scrollTrigger: {
          trigger: hero,
          start: 'top top',
          end: 'bottom top',
          scrub: true
        }
      });
    }
  }

  // ============ SECTION HEADER REVEAL (label → title → divider line draw) ============
  function initSectionHeaders() {
    document.querySelectorAll('.cat-section-header, .home-collections-header').forEach(header => {
      const label = header.querySelector('.cat-section-label, .hc-section-label');
      const title = header.querySelector('.cat-section-title, .hc-section-title');
      const divider = header.querySelector('.cat-section-divider, .hc-section-divider');

      if (divider) gsap.set(divider, { scaleX: 0, transformOrigin: 'center' });

      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: header,
          start: 'top 80%',
          once: true
        },
        defaults: { ease: 'power3.out' }
      });

      if (label) tl.fromTo(label, { opacity: 0, y: 12 }, { opacity: 1, y: 0, duration: 0.6 });
      if (title) tl.fromTo(title, { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.7 }, 0.15);
      if (divider) tl.to(divider, { scaleX: 1, duration: 0.6 }, 0.5);
    });
  }

  // ============ CATEGORY CARDS — clip reveal + parallax image drift ============
  function initCategoryCards() {
    const cards = gsap.utils.toArray('.cat-card');
    if (!cards.length) return;

    cards.forEach((card, i) => {
      const img = card.querySelector('.cat-card-img');
      const bg = card.querySelector('.cat-card-bg');

      gsap.fromTo(card,
        { opacity: 0, y: 50 },
        {
          opacity: 1, y: 0, duration: 0.9, ease: 'power3.out',
          delay: i * 0.12,
          scrollTrigger: { trigger: card, start: 'top 85%', once: true }
        }
      );

      // Subtle parallax drift inside the card (image or color bg)
      const target = img || bg;
      if (target) {
        gsap.fromTo(target,
          { yPercent: -6 },
          {
            yPercent: 6,
            ease: 'none',
            scrollTrigger: {
              trigger: card,
              start: 'top bottom',
              end: 'bottom top',
              scrub: true
            }
          }
        );
      }
    });
  }

  // ============ COLLECTIONS CARDS — stagger scale+fade ============
  function initCollectionCards() {
    const cards = gsap.utils.toArray('.hc-card');
    if (!cards.length) return;

    gsap.fromTo(cards,
      { opacity: 0, y: 40, scale: 0.96 },
      {
        opacity: 1, y: 0, scale: 1, duration: 0.8, ease: 'power3.out',
        stagger: 0.12,
        scrollTrigger: {
          trigger: cards[0].closest('.home-collections-grid'),
          start: 'top 85%',
          once: true
        }
      }
    );
  }

  // ============ FEATURED PRODUCTS — row stagger ============
  function initFeaturedProducts() {
    const section = document.querySelector('.featured-section .products-grid');
    if (!section) return;
    const cards = gsap.utils.toArray(section.querySelectorAll('.product-card'));
    if (!cards.length) return;

    gsap.fromTo(cards,
      { opacity: 0, y: 36, scale: 0.97 },
      {
        opacity: 1, y: 0, scale: 1, duration: 0.7, ease: 'power3.out',
        stagger: { each: 0.08, grid: 'auto', from: 'start' },
        scrollTrigger: {
          trigger: section,
          start: 'top 88%',
          once: true
        }
      }
    );
  }

    // ============ DARK HEADER BANNERS — breadcrumb/title/subtitle cascade + parallax bg ============
    function initHeaderBanners() {
        const headers = document.querySelectorAll('.category-hero, .shop-header');

        headers.forEach(header => {
        const breadcrumb = header.querySelector('.breadcrumb');
        const label = header.querySelector('.section-label');
        const title = header.querySelector('.category-hero-title, .shop-title');
        const subtitle = header.querySelector('p');
        const bgImg = header.querySelector('.header-banner-img');

        // Background: gentle zoom-settle on load, like the home hero
        if (bgImg) {
            gsap.fromTo(bgImg,
            { scale: 1.1 },
            { scale: 1, duration: 1.8, ease: 'power2.out' }
            );

            // Parallax drift as user scrolls past this banner
            gsap.to(bgImg, {
            yPercent: 10,
            ease: 'none',
            scrollTrigger: {
                trigger: header,
                start: 'top top',
                end: 'bottom top',
                scrub: true
            }
            });
        }

        const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

        if (breadcrumb) tl.fromTo(breadcrumb, { opacity: 0, y: 10 }, { opacity: 1, y: 0, duration: 0.5 }, 0.1);
        if (label) tl.fromTo(label, { opacity: 0, y: 10 }, { opacity: 1, y: 0, duration: 0.5 }, 0.15);
        if (title) tl.fromTo(title, { opacity: 0, y: 18 }, { opacity: 1, y: 0, duration: 0.7 }, 0.25);
        if (subtitle) tl.fromTo(subtitle, { opacity: 0, y: 12 }, { opacity: 1, y: 0, duration: 0.6 }, 0.45);
        });
    }

    // ============ SHOP PAGE PRODUCT GRID — stagger reveal ============
    function initShopProductGrid() {
        const grid = document.querySelector('.shop-main .products-grid');
        if (!grid) return;

        const cards = gsap.utils.toArray(grid.querySelectorAll('.product-card'));
        if (!cards.length) return;

        // Disable the plain CSS .reveal class behavior for these cards —
        // GSAP now owns their entrance instead
        cards.forEach(c => c.classList.remove('reveal'));

        gsap.fromTo(cards,
        { opacity: 0, y: 36, scale: 0.97 },
        {
            opacity: 1, y: 0, scale: 1, duration: 0.7, ease: 'power3.out',
            stagger: { each: 0.07, grid: 'auto', from: 'start' },
            scrollTrigger: {
            trigger: grid,
            start: 'top 88%',
            once: true
            }
        }
        );
    }


  document.addEventListener('DOMContentLoaded', function () {
    initHero();
    initSectionHeaders();
    initCategoryCards();
    initCollectionCards();
    initFeaturedProducts();
    initHeaderBanners();
    initShopProductGrid();
  });
})();