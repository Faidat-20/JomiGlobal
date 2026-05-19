CREATE TABLE collections (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    image VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert JomiGlobal collections
INSERT INTO collections (name, slug, description) VALUES
('For Her', 'for-her', 'Luxury pieces curated for women'),
('For Him', 'for-him', 'Premium selections curated for men'),
('Gift Ideas', 'gift-ideas', 'Perfect gifts for every occasion'),
('Customised', 'customised', 'Personalised and custom made pieces');