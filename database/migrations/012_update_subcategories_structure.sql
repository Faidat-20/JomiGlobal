ALTER TABLE subcategories ADD COLUMN parent_id INT UNSIGNED NULL AFTER category_id;
ALTER TABLE subcategories ADD FOREIGN KEY (parent_id) REFERENCES subcategories(id) ON DELETE CASCADE;


DELETE FROM subcategories;
ALTER TABLE subcategories AUTO_INCREMENT = 1;

-- JEWELRY
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, NULL, 'For Her', 'jewelry-for-her');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, NULL, 'For Him', 'jewelry-for-him');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 1, 'Rings', 'jewelry-her-rings');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 1, 'Necklaces', 'jewelry-her-necklaces');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 1, 'Bracelets', 'jewelry-her-bracelets');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 1, 'Earrings', 'jewelry-her-earrings');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 1, 'Anklets', 'jewelry-her-anklets');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 1, 'Pendants', 'jewelry-her-pendants');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 1, 'Charms', 'jewelry-her-charms');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 2, 'Rings', 'jewelry-him-rings');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 2, 'Bracelets', 'jewelry-him-bracelets');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 2, 'Chains', 'jewelry-him-chains');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (1, 2, 'Cufflinks', 'jewelry-him-cufflinks');

-- PERFUME
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (2, NULL, 'For Her', 'perfume-for-her');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (2, NULL, 'For Him', 'perfume-for-him');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (2, NULL, 'Unisex', 'perfume-unisex');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (2, NULL, 'Gift Sets', 'perfume-gift-sets');

-- GLASSES
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (3, NULL, 'Sunglasses', 'glasses-sunglasses');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (3, NULL, 'Eyeglasses', 'glasses-eyeglasses');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (3, NULL, 'Reading Glasses', 'glasses-reading');
INSERT INTO subcategories (category_id, parent_id, name, slug) VALUES (3, NULL, 'Sports Glasses', 'glasses-sports');