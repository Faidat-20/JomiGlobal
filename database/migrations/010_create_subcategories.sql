CREATE TABLE subcategories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(100) NOT NULL,
  image VARCHAR(255),
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

ALTER TABLE products ADD COLUMN subcategory_id INT UNSIGNED AFTER category_id;
ALTER TABLE products ADD FOREIGN KEY (subcategory_id) REFERENCES subcategories(id) ON DELETE SET NULL;

INSERT INTO subcategories (category_id, name, slug) VALUES
(1, 'Rings', 'rings'),
(1, 'Necklaces', 'necklaces'),
(1, 'Bracelets', 'bracelets'),
(1, 'Earrings', 'earrings'),
(1, 'Anklets', 'anklets'),
(1, 'Pendants', 'pendants'),
(1, 'Charms', 'charms'),
(2, 'For Women', 'for-women'),
(2, 'For Men', 'for-men'),
(2, 'Unisex', 'unisex'),
(2, 'Gift Sets', 'gift-sets'),
(3, 'Sunglasses', 'sunglasses'),
(3, 'Eyeglasses', 'eyeglasses'),
(3, 'Reading Glasses', 'reading-glasses'),
(3, 'Sports Glasses', 'sports-glasses');