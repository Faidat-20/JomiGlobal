<main class="category-page">

  <!-- Category Header -->
  <div class="category-hero">
    <div class="header-banner-bg">
      <?php
        $headerImages = [
          'jewelry' => '/uploads/product_6a3514a3c7c6a.png',
          'perfume' => '/assets/images/laura-chouette-2H_8WbVPRxM-unsplash.jpg',
          'glasses' => '/assets/images/category eyewear.jpg',
        ];
        $headerImg = $headerImages[$categorySlug] ?? $headerImages['jewelry'];
      ?>
      <img src="<?= APP_URL . $headerImg ?>" alt="" class="header-banner-img" id="headerBannerImg">
    </div>
    <div class="container">
      <div class="breadcrumb" style="margin-bottom:16px;">
        <a href="<?= APP_URL ?>">Home</a>
        <span>/</span>
        <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>"><?= htmlspecialchars($category['name']) ?></a>
      </div>
      <h1 class="category-hero-title"><?= htmlspecialchars($category['name']) ?></h1>
    </div>
  </div>

  <!-- Groups Grid -->
  <div class="container">
    <div class="category-groups">
      <?php foreach ($groups as $group): $i = 0; ?>
        <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>"
           class="category-group-card">

          <!-- Slider -->
          <div class="cg-slider" data-offset="<?= ($i % 2) * 1500 ?>">
            <?php if (!empty($group['images'])): ?>
              <?php foreach ($group['images'] as $img): ?>
                <div class="cg-slide" data-subcat="<?= htmlspecialchars($img['subcat_name']) ?>">
                  <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($img['image']) ?>" alt="">
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="cg-slide cg-placeholder">
                <?php if ($category['slug'] === 'jewelry'): ?>
                  <i class="ti ti-diamond"></i>
                <?php elseif ($category['slug'] === 'perfume'): ?>
                  <i class="ti ti-bottle"></i>
                <?php else: ?>
                  <i class="ti ti-eyeglass"></i>
                <?php endif; ?>
              </div>
              <div class="cg-slide cg-placeholder"><i class="ti ti-heart"></i></div>
              <div class="cg-slide cg-placeholder"><i class="ti ti-sparkles"></i></div>
              <div class="cg-slide cg-placeholder"><i class="ti ti-star"></i></div>
              <div class="cg-slide cg-placeholder"><i class="ti ti-crown"></i></div>
            <?php endif; ?>
          </div>

          <!-- Corner frames -->
          <div class="cg-corner cg-tl"></div>
          <div class="cg-corner cg-bl"></div>

          <!-- Subcategory pill (only shows when real images exist) -->
          <?php if (!empty($group['images'])): ?>
            <div class="cg-subcat-pill"></div>
          <?php endif; ?>

          <!-- Overlay -->
          <div class="cg-overlay">
            <div class="cg-top">
              <span class="cg-counter">01 / 05</span>
            </div>
            <div class="cg-bottom">
              <div class="cg-dots"></div>
              <h2><?= htmlspecialchars($group['name']) ?></h2>
              <span class="cg-cta"><div class="cg-bar"></div> Shop Now</span>
            </div>
          </div>

        </a>
      <?php $i++; endforeach; ?>
    </div>
  </div>

</main>

<script>
document.querySelectorAll('.category-group-card').forEach(function(card, cardIndex) {
  const slider = card.querySelector('.cg-slider');
  const dotsContainer = card.querySelector('.cg-dots');
  const counter = card.querySelector('.cg-counter');
  const slides = slider.querySelectorAll('.cg-slide');
  const total = slides.length;
  let current = 0;

  // Build dots
  slides.forEach(function(_, i) {
    const d = document.createElement('div');
    d.className = 'cg-dot' + (i === 0 ? ' active' : '');
    dotsContainer.appendChild(d);
  });

  function pad(n) { return String(n).padStart(2, '0'); }

  const subcatPill = card.querySelector('.cg-subcat-pill');

  function goTo(index) {
    current = index % total;
    slider.style.transform = 'translateX(-' + (current * 100) + '%)';
    dotsContainer.querySelectorAll('.cg-dot').forEach(function(d, i) {
      d.classList.toggle('active', i === current);
    });
    if (counter) counter.textContent = pad(current + 1) + ' / ' + pad(total);

    if (subcatPill) {
      const activeSlide = slides[current];
      const subcatName = activeSlide.getAttribute('data-subcat');
      if (subcatName) {
        subcatPill.textContent = subcatName;
        subcatPill.style.display = 'block';
      } else {
        subcatPill.style.display = 'none';
      }
    }
  }

  goTo(0);

  setTimeout(function() {
    setInterval(function() { goTo(current + 1); }, 3000);
  }, cardIndex * 1500);
});
</script>