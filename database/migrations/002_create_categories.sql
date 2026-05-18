CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories
INSERT INTO categories (name, slug, description) VALUES
('Jewelry', 'jewelry', 'Luxury rings, necklaces, bracelets and earrings'),
('Perfume', 'perfume', 'Exclusive fragrances for men and women'),
('Glasses', 'glasses', 'Premium eyewear and sunglasses');