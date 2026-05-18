CREATE TABLE orders (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED,
  order_number VARCHAR(50) NOT NULL UNIQUE,
  status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded') DEFAULT 'pending',
  subtotal DECIMAL(15, 2) NOT NULL,
  shipping_fee DECIMAL(15, 2) DEFAULT 0.00,
  discount DECIMAL(15, 2) DEFAULT 0.00,
  total DECIMAL(15, 2) NOT NULL,
  currency VARCHAR(10) DEFAULT 'NGN',
  
  -- Shipping details
  shipping_first_name VARCHAR(50) NOT NULL,
  shipping_last_name VARCHAR(50) NOT NULL,
  shipping_email VARCHAR(100) NOT NULL,
  shipping_phone VARCHAR(30) NOT NULL,
  shipping_address TEXT NOT NULL,
  shipping_city VARCHAR(50) NOT NULL,
  shipping_state VARCHAR(50) NOT NULL,
  shipping_country VARCHAR(50) NOT NULL DEFAULT 'Nigeria',
  shipping_zip VARCHAR(20),
  
  -- Tracking
  tracking_number VARCHAR(100),
  notes TEXT,
  
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);