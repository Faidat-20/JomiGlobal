// GSAP ANIMATIONS
(function() {
  if (typeof gsap === 'undefined') return;

  gsap.registerPlugin(ScrollTrigger);

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (reduceMotion) {
    gsap.set('.reveal, .cat-card, .hc-card, .product-card', { opacity: 1, y: 0, scale: 1 });
    return;
  }

  // HERO ENTRANCE
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

    [labelRow, title, text, btns].forEach(el => {
      if (el) el.style.animation = 'none';
    });

    if (bgImg) {
      gsap.fromTo(bgImg,
        { scale: 1.12 },
        { scale: 1, duration: 2.2, ease: 'power2.out' }
      );
    }

    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

    tl.fromTo(labelRow, { opacity: 0, y: 16 }, { opacity: 1, y: 0, duration: 0.7 }, 0.2)
      .fromTo(title, { opacity: 0, y: 28 }, { opacity: 1, y: 0, duration: 0.9 }, 0.35)
      .fromTo(divider, { opacity: 0, scaleX: 0 }, { opacity: 1, scaleX: 1, duration: 0.6 }, 0.75)
      .fromTo(text, { opacity: 0, y: 16 }, { opacity: 1, y: 0, duration: 0.7 }, 0.85)
      .fromTo(btns, { opacity: 0, y: 16 }, { opacity: 1, y: 0, duration: 0.7 }, 1.0)
      .fromTo(scrollInd, { opacity: 0 }, { opacity: 1, duration: 0.6 }, 1.4);

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

  // SECTION HEADER REVEAL
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

  // CATEGORY CARDS
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

  // COLLECTIONS CARDS
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

  // FEATURED PRODUCTS
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

  // DARK HEADER BANNERS
  function initHeaderBanners() {
    const headers = document.querySelectorAll('.category-hero, .shop-header');

    headers.forEach(header => {
      const breadcrumb = header.querySelector('.breadcrumb');
      const label = header.querySelector('.section-label');
      const title = header.querySelector('.category-hero-title, .shop-title');
      const subtitle = header.querySelector('p');
      const bgImg = header.querySelector('.header-banner-img');

      if (bgImg) {
        gsap.fromTo(bgImg,
          { scale: 1.1 },
          { scale: 1, duration: 1.8, ease: 'power2.out' }
        );

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

  // SHOP PRODUCT GRID
  function initShopProductGrid() {
    const grid = document.querySelector('.shop-main .products-grid');
    if (!grid) return;

    const cards = gsap.utils.toArray(grid.querySelectorAll('.product-card'));
    if (!cards.length) return;

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

  function initFeaturedCarousel() {
    const carousel = document.getElementById('featuredCarousel');
    const track = document.getElementById('featuredTrack');
    const dotsContainer = document.getElementById('featuredDots');
    if (!carousel || !track) return;

    const cards = Array.from(track.querySelectorAll('.product-card'));
    if (!cards.length) return;

    let currentIndex = 0;
    let autoTimer = null;
    let touchStartX = 0;
    let isDragging = false;
    let dragStartX = 0;

    function getVisible() {
      if (window.innerWidth <= 480) return 1;
      if (window.innerWidth <= 768) return 2;
      if (window.innerWidth <= 1024) return 3;
      return 4;
    }

    function getMaxIndex() {
      return Math.max(0, cards.length - getVisible());
    }

    function getCardWidth() {
      return cards[0].getBoundingClientRect().width + 20;
    }

    const MAX_VISIBLE_DOTS = 5;

    function buildDots() {
      if (!dotsContainer) return;
      dotsContainer.innerHTML = '';
      dotsContainer.style.display = 'flex';
      const total = getMaxIndex() + 1;
      const count = Math.min(total, MAX_VISIBLE_DOTS);
      for (let i = 0; i < count; i++) {
        const dot = document.createElement('button');
        dot.className = 'featured-dot';
        dot.addEventListener('click', () => {
          const total = getMaxIndex() + 1;
          const windowStart = getDotWindowStart();
          goTo(windowStart + i);
          resetAuto();
        });
        dotsContainer.appendChild(dot);
      }
      updateDots();
    }

    function getDotWindowStart() {
      const total = getMaxIndex() + 1;
      const half = Math.floor(MAX_VISIBLE_DOTS / 2);
      let start = currentIndex - half;
      start = Math.max(0, start);
      start = Math.min(start, Math.max(0, total - MAX_VISIBLE_DOTS));
      return start;
    }

    function updateDots() {
      if (!dotsContainer) return;
      const dots = dotsContainer.querySelectorAll('.featured-dot');
      const windowStart = getDotWindowStart();
      dots.forEach((dot, i) => {
        const slideIndex = windowStart + i;
        dot.classList.toggle('active', slideIndex === currentIndex);
        // Scale effect — smaller dots at edges like Instagram
        const distFromActive = Math.abs(slideIndex - currentIndex);
        if (distFromActive === 0) {
          dot.style.transform = 'scale(1.3)';
          dot.style.background = 'var(--mustard)';
        } else if (distFromActive === 1) {
          dot.style.transform = 'scale(1.0)';
          dot.style.background = 'rgba(65,64,66,0.3)';
        } else {
          dot.style.transform = 'scale(0.7)';
          dot.style.background = 'rgba(65,64,66,0.15)';
        }
      });
    }

    function goTo(index) {
      const max = getMaxIndex();
      // Loop back to start when exceeding max
      if (index > max) {
        currentIndex = 0;
      } else if (index < 0) {
        currentIndex = max;
      } else {
        currentIndex = index;
      }
      const offset = currentIndex * getCardWidth();
      track.style.transition = 'transform 0.6s cubic-bezier(0.4,0,0.2,1)';
      track.style.transform = `translateX(-${offset}px)`;
      updateDots();
    }

    function next() {
      goTo(currentIndex + 1);
    }

    function startAuto() {
      clearInterval(autoTimer);
      autoTimer = setInterval(next, 2500);
    }

    function resetAuto() {
      startAuto();
    }

    function stopAuto() {
      clearInterval(autoTimer);
    }

    // Touch support
    carousel.addEventListener('touchstart', (e) => {
      touchStartX = e.touches[0].clientX;
      stopAuto();
      track.style.transition = 'none';
    }, { passive: true });

    let touchStartY = 0;

    carousel.addEventListener('touchstart', (e) => {
      touchStartX = e.touches[0].clientX;
      touchStartY = e.touches[0].clientY;
      stopAuto();
      track.style.transition = 'none';
    }, { passive: true });

    carousel.addEventListener('touchmove', (e) => {
      const diffX = e.touches[0].clientX - touchStartX;
      const diffY = e.touches[0].clientY - touchStartY;

      if (Math.abs(diffX) > Math.abs(diffY)) {
        e.preventDefault(); // block browser back/forward
        const currentOffset = currentIndex * getCardWidth();
        track.style.transform = `translateX(${-currentOffset + diffX}px)`;
      }
    }, { passive: false });

    carousel.addEventListener('touchend', (e) => {
      const diff = e.changedTouches[0].clientX - touchStartX;
      if (diff < -50) {
        goTo(currentIndex + 1);
      } else if (diff > 50) {
        goTo(currentIndex - 1);
      } else {
        goTo(currentIndex);
      }
      resetAuto();
    });

    // Mouse drag support
    carousel.addEventListener('mousedown', (e) => {
      isDragging = true;
      dragStartX = e.clientX;
      stopAuto();
      track.style.transition = 'none';
      carousel.style.cursor = 'grabbing';
    });

    window.addEventListener('mousemove', (e) => {
      if (!isDragging) return;
      const diff = e.clientX - dragStartX;
      const currentOffset = currentIndex * getCardWidth();
      track.style.transform = `translateX(${-currentOffset + diff}px)`;
    });

    window.addEventListener('mouseup', (e) => {
      if (!isDragging) return;
      const diff = e.clientX - dragStartX;
      isDragging = false;
      carousel.style.cursor = 'grab';
      if (diff < -50) {
        goTo(currentIndex + 1);
      } else if (diff > 50) {
        goTo(currentIndex - 1);
      } else {
        goTo(currentIndex);
      }
      resetAuto();
    });

    // Pause on hover
    carousel.addEventListener('mouseenter', stopAuto);
    carousel.addEventListener('mouseleave', startAuto);

    // Rebuild on resize
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        buildDots();
        goTo(0);
      }, 200);
    });

    // Init
    buildDots();
    startAuto();

    // Entrance animation
    gsap.fromTo(cards,
      { opacity: 0, y: 36, scale: 0.97 },
      {
        opacity: 1, y: 0, scale: 1, duration: 0.7, ease: 'power3.out',
        stagger: { each: 0.08, from: 'start' },
        scrollTrigger: {
          trigger: carousel,
          start: 'top 88%',
          once: true
        }
      }
    );
  }

  function initFeaturedProducts() {}

  document.addEventListener('DOMContentLoaded', function() {
    initHero();
    initSectionHeaders();
    initCategoryCards();
    initCollectionCards();
    initFeaturedProducts();
    initHeaderBanners();
    initShopProductGrid();
    initFeaturedCarousel();
  });

})();