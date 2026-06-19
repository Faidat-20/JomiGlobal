<main class="contact-page">

  <!-- Hero -->
  <div class="contact-hero">
    <div class="contact-hero-line"></div>
    <span class="contact-label">Get In Touch</span>
    <h1>Contact Us</h1>
    <p>We'd love to hear from you. Our team is always here to help with any questions or inquiries.</p>
  </div>

  <!-- Body -->
  <div class="contact-body">

    <!-- Left -->
    <div class="contact-left">
      <h2>How Can We Help?</h2>
      <p>Whether you have a question about our products, your order, or anything else — our team is ready to answer.</p>

      <div class="contact-cards">
        <div class="contact-card">
          <div class="contact-card-icon"><i class="ti ti-mail"></i></div>
          <h4>Email Us</h4>
          <a href="mailto:hello@jomiglobal.com">hello@jomiglobal.com</a>
          <p>We reply within 24 hours</p>
        </div>

        <div class="contact-card">
          <div class="contact-card-icon"><i class="ti ti-phone"></i></div>
          <h4>Call Us</h4>
          <p>+234 800 000 0000</p>
          <p>Mon–Sat, 9am–6pm</p>
        </div>

        <div class="contact-card">
          <div class="contact-card-icon"><i class="ti ti-map-pin"></i></div>
          <h4>Location</h4>
          <p>Lagos, Nigeria</p>
          <p>Worldwide Delivery</p>
        </div>

        <div class="contact-card">
          <div class="contact-card-icon"><i class="ti ti-brand-instagram"></i></div>
          <h4>Social Media</h4>
          <a href="#">Instagram</a><br>
          <a href="#">WhatsApp</a>
        </div>
      </div>
    </div>

    <!-- Right: Form -->
    <div class="contact-form-wrapper">

      <?php if ($success): ?>
        <div class="contact-success">
          <i class="ti ti-circle-check"></i>
          <h3>Message Sent!</h3>
          <p><?= $success ?></p>
          <a href="<?= APP_URL ?>/shop" class="btn btn-primary" style="margin-top:16px;">Continue Shopping</a>
        </div>
      <?php else: ?>

        <h3>Send a Message</h3>
        <p>Fill out the form and we'll get back to you as soon as possible.</p>

        <?php if ($error): ?>
          <div class="alert alert-error" style="margin-bottom:20px;">
            <i class="ti ti-alert-circle"></i> <?= $error ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="<?= APP_URL ?>/contact">
          <div class="contact-form-field">
            <label>Full Name *</label>
            <input type="text" name="name" placeholder="Enter your full name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
          </div>

          <div class="contact-form-field">
            <label>Email Address *</label>
            <input type="email" name="email" placeholder="your@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
          </div>

          <div class="contact-form-field">
            <label>Subject</label>
            <select name="subject">
              <option value="">Select a topic</option>
              <option value="Order Enquiry" <?= ($_POST['subject'] ?? '') === 'Order Enquiry' ? 'selected' : '' ?>>Order Enquiry</option>
              <option value="Product Question" <?= ($_POST['subject'] ?? '') === 'Product Question' ? 'selected' : '' ?>>Product Question</option>
              <option value="Shipping & Delivery" <?= ($_POST['subject'] ?? '') === 'Shipping & Delivery' ? 'selected' : '' ?>>Shipping & Delivery</option>
              <option value="Returns & Refunds" <?= ($_POST['subject'] ?? '') === 'Returns & Refunds' ? 'selected' : '' ?>>Returns & Refunds</option>
              <option value="Partnership" <?= ($_POST['subject'] ?? '') === 'Partnership' ? 'selected' : '' ?>>Partnership</option>
              <option value="Other" <?= ($_POST['subject'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
          </div>

          <div class="contact-form-field">
            <label>About Your Inquiry *</label>
            <textarea name="message" placeholder="Enter your message here..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
          </div>

          <button type="submit" class="contact-submit">
            Send Message <i class="ti ti-arrow-right"></i>
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</main>