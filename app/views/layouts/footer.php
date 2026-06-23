<footer class="footer">
    
  <!-- Top Footer -->
  <div class="footer-top">
    <div class="footer-container">

      <!-- Brand Column -->
      <div class="footer-col footer-brand">
        <a href="<?= APP_URL ?>" class="footer-logo">
          <img src="<?= APP_URL ?>/assets/images/logo.png" alt="JomiGlobal">
        </a>
        <p class="footer-tagline">Luxury Jewelry, Perfume & Glasses for the discerning individual.</p>
        <!-- Social Links -->
        <div class="footer-socials">
          <a href="#" class="social-link"><i class="ti ti-brand-instagram"></i></a>
          <a href="#" class="social-link"><i class="ti ti-brand-facebook"></i></a>
          <a href="#" class="social-link"><i class="ti ti-brand-tiktok"></i></a>
          <a href="#" class="social-link"><i class="ti ti-brand-twitter"></i></a>
        </div>
      </div>

      <!-- Shop Column -->
      <div class="footer-col">
        <h4 class="footer-heading">Shop</h4>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/category/jewelry">Jewelry</a></li>
          <li><a href="<?= APP_URL ?>/category/perfume">Perfume</a></li>
          <li><a href="<?= APP_URL ?>/category/glasses">Glasses</a></li>
          <li><a href="<?= APP_URL ?>/collections/for-her">For Her</a></li>
          <li><a href="<?= APP_URL ?>/collections/for-him">For Him</a></li>
          <li><a href="<?= APP_URL ?>/collections/gift-ideas">Gift Ideas</a></li>
          <li><a href="<?= APP_URL ?>/collections/customised">Customised</a></li>
        </ul>
      </div>

      <!-- Help Column -->
      <div class="footer-col">
        <h4 class="footer-heading">Help</h4>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/order-tracking">Track Your Order</a></li>
          <li><a href="<?= APP_URL ?>/faq">FAQ</a></li>
          <li><a href="<?= APP_URL ?>/shipping">Shipping & Delivery</a></li>
          <li><a href="<?= APP_URL ?>/returns">Returns & Exchanges</a></li>
          <li><a href="<?= APP_URL ?>/contact">Contact Us</a></li>
        </ul>
      </div>

      <!-- Info Column -->
      <div class="footer-col">
        <h4 class="footer-heading">Information</h4>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/about">About Us</a></li>
          <li><a href="<?= APP_URL ?>/privacy-policy">Privacy Policy</a></li>
          <li><a href="<?= APP_URL ?>/terms">Terms & Conditions</a></li>
        </ul>

        <!-- Contact Info -->
        <div class="footer-contact">
          <p><i class="ti ti-mail"></i> hello@jomiglobal.com</p>
          <p><i class="ti ti-phone"></i> +234 800 000 0000</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Footer -->
  <div class="footer-bottom">
    <div class="footer-container">
      <p>&copy; <?= date('Y') ?> JomiGlobal. All rights reserved.</p>
      <div class="payment-icons">
        <span>We accept:</span>
        <i class="ti ti-credit-card"></i>
        <i class="ti ti-brand-mastercard"></i>
        <span>Flutterwave</span>
      </div>
    </div>
  </div>

  <!-- Newsletter Popup -->
  <div class="newsletter-overlay" id="newsletterOverlay">
    <div class="newsletter-modal">
      <button class="newsletter-close" id="newsletterClose">
        <i class="ti ti-x"></i>
      </button>
      <div class="newsletter-content">
        <div class="newsletter-icon">✨</div>
        <h3>Join the JomiGlobal Family</h3>
        <p>Subscribe to receive exclusive offers, new arrivals and luxury inspiration straight to your inbox.</p>
        <form class="newsletter-form" id="newsletterForm">
          <input
            type="text"
            name="name"
            placeholder="Your name"
            required
          >
          <input
            type="email"
            name="email"
            placeholder="Your email address"
            required
          >
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
            Subscribe
          </button>
        </form>
        <p class="newsletter-privacy">We respect your privacy. Unsubscribe anytime.</p>
      </div>
    </div>
  </div>

</footer>

<!-- Main JS -->
<script src="<?= APP_URL ?>/assets/js/main.js"></script>
<script src="<?= APP_URL ?>/assets/js/cart.js"></script>
<script src="<?= APP_URL ?>/assets/js/shop.js"></script>
<script src="<?= APP_URL ?>/assets/js/animations.js"></script>
</body>
</html>