<main class="tracking-page">
  <div class="container">

    <div class="tracking-header">
      <h1>Track Your Order</h1>
      <p>Enter your order number and email to track your order status</p>
    </div>

    <!-- Search Form -->
    <div class="tracking-form-wrapper">
      <form method="POST" action="<?= APP_URL ?>/order-tracking" class="tracking-form">
        <?php if ($error): ?>
          <div class="alert alert-error" style="margin-bottom:20px;">
            <i class="ti ti-alert-circle"></i> <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <div class="tracking-form-fields">
          <div class="checkout-field">
            <label>Order Number</label>
            <input
              type="text"
              name="order_number"
              placeholder="e.g. TRK-1778490491956-JM0LB"
              value="<?= htmlspecialchars($_POST['order_number'] ?? '') ?>"
              required
            >
          </div>
          <div class="checkout-field">
            <label>Email Address</label>
            <input
              type="email"
              name="email"
              placeholder="your@email.com"
              value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
              required
            >
          </div>
          <button type="submit" class="btn btn-primary tracking-submit">
            <i class="ti ti-search"></i> Track Order
          </button>
        </div>
      </form>
    </div>

    <?php if ($order): ?>
      <!-- Order Found -->
      <div class="tracking-result">

        <!-- Order Info -->
        <div class="tracking-info">
          <div class="tracking-order-num">
            <span>Order</span>
            <strong>#<?= htmlspecialchars($order['order_number']) ?></strong>
          </div>
          <div class="tracking-order-date">
            <span>Placed on</span>
            <strong><?= date('F j, Y', strtotime($order['created_at'])) ?></strong>
          </div>
          <div class="tracking-order-total">
            <span>Total</span>
            <strong><?= CURRENCY_SYMBOL . number_format($order['total'], 2) ?></strong>
          </div>
        </div>

        <!-- Status Timeline -->
        <?php
          $steps = [
            'pending'    => ['label' => 'Order Placed',   'icon' => 'ti-check',          'desc' => 'Your order has been received'],
            'confirmed'  => ['label' => 'Confirmed',      'icon' => 'ti-circle-check',   'desc' => 'Your order has been confirmed'],
            'processing' => ['label' => 'Processing',     'icon' => 'ti-package',        'desc' => 'Your order is being prepared'],
            'shipped'    => ['label' => 'Shipped',        'icon' => 'ti-truck',          'desc' => 'Your order is on its way'],
            'delivered'  => ['label' => 'Delivered',      'icon' => 'ti-home-check',     'desc' => 'Your order has been delivered'],
          ];

          $statusOrder = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
          $currentIndex = array_search($order['status'], $statusOrder);
          if ($currentIndex === false) $currentIndex = 0;
        ?>

        <div class="tracking-timeline">
          <?php foreach ($steps as $key => $step):
            $stepIndex = array_search($key, $statusOrder);
            $isDone    = $stepIndex < $currentIndex;
            $isCurrent = $stepIndex === $currentIndex;
            $isPending = $stepIndex > $currentIndex;

            // Handle cancelled/refunded
            if (in_array($order['status'], ['cancelled', 'refunded'])) {
              $isDone = false;
              $isCurrent = ($key === 'pending');
              $isPending = ($key !== 'pending');
            }
          ?>
            <div class="timeline-step <?= $isDone ? 'done' : ($isCurrent ? 'current' : 'pending') ?>">
              <div class="timeline-icon">
                <i class="ti <?= $step['icon'] ?>"></i>
              </div>
              <div class="timeline-content">
                <strong><?= $step['label'] ?></strong>
                <p><?= $step['desc'] ?></p>
              </div>
              <?php if (!$isPending): ?>
                <div class="timeline-line"></div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <?php if (in_array($order['status'], ['cancelled', 'refunded'])): ?>
          <div class="alert alert-error" style="margin:24px 0;">
            <i class="ti ti-alert-circle"></i>
            This order has been <?= $order['status'] ?>.
            <?php if ($order['status'] === 'refunded'): ?>
              Your refund is being processed.
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- Tracking Number -->
        <?php if ($order['tracking_number']): ?>
          <div class="tracking-number-box">
            <i class="ti ti-truck"></i>
            <div>
              <p>Tracking Number</p>
              <strong><?= htmlspecialchars($order['tracking_number']) ?></strong>
            </div>
          </div>
        <?php endif; ?>

        <!-- Shipping Address -->
        <div class="tracking-details">
          <div class="tracking-detail-card">
            <h4>Shipping To</h4>
            <p><?= htmlspecialchars($order['shipping_first_name'] . ' ' . $order['shipping_last_name']) ?></p>
            <p><?= htmlspecialchars($order['shipping_address']) ?></p>
            <p><?= htmlspecialchars($order['shipping_city'] . ', ' . $order['shipping_state']) ?></p>
            <p><?= htmlspecialchars($order['shipping_country']) ?></p>
            <p><?= htmlspecialchars($order['shipping_phone']) ?></p>
          </div>

          <!-- Order Items -->
          <div class="tracking-detail-card">
            <h4>Order Items</h4>
            <?php foreach ($orderItems as $item): ?>
              <div class="tracking-item">
                <?php if (!empty($item['image'])): ?>
                  <img src="<?= APP_URL ?>/uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                <?php else: ?>
                  <div class="tracking-item-no-img"><i class="ti ti-photo"></i></div>
                <?php endif; ?>
                <div>
                  <p><?= htmlspecialchars($item['product_name']) ?></p>
                  <span>Qty: <?= $item['quantity'] ?> × <?= CURRENCY_SYMBOL . number_format($item['price'], 2) ?></span>
                </div>
                <strong><?= CURRENCY_SYMBOL . number_format($item['total'], 2) ?></strong>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div>
    <?php endif; ?>

  </div>
</main>