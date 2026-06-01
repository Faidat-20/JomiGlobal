<main class="category-page">

  <!-- Category Header -->
  <div class="category-hero">
    <div class="container">
      <div class="breadcrumb" style="margin-bottom:16px;">
        <a href="<?= APP_URL ?>">Home</a>
        <span>/</span>
        <span><?= htmlspecialchars($category['name']) ?></span>
      </div>
      <h1 class="category-hero-title"><?= htmlspecialchars($category['name']) ?></h1>
    </div>
  </div>

  <!-- Groups Grid -->
  <div class="container">
    <div class="category-groups">
      <?php foreach ($groups as $group): ?>
        
        <a href="<?= APP_URL ?>/category/<?= $categorySlug ?>/<?= $group['slug'] ?>"
          class="category-group-card"
        >
          <div class="category-group-image">
            <?php if (!empty($group['image'])): ?>
              <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($group['image']) ?>" alt="<?= htmlspecialchars($group['name']) ?>">
            <?php else: ?>
              <div class="category-group-placeholder">
                <?php if ($category['slug'] === 'jewelry'): ?>
                  <i class="ti ti-diamond"></i>
                <?php elseif ($category['slug'] === 'perfume'): ?>
                  <i class="ti ti-bottle"></i>
                <?php else: ?>
                  <i class="ti ti-eyeglass"></i>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <div class="category-group-overlay">
              <h2><?= htmlspecialchars($group['name']) ?></h2>
              <span class="category-group-cta">Shop Now <i class="ti ti-arrow-right"></i></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

</main>