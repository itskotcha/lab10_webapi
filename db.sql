CREATE DATABASE IF NOT EXISTS lab10_webapi
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE lab10_webapi;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  description TEXT,
  category VARCHAR(100),
  image VARCHAR(255),
  rating_rate DECIMAL(3,2) DEFAULT 0.00,
  rating_count INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--20 example products
INSERT INTO products (title, price, description, category, image, rating_rate, rating_count) VALUES
('Classic Cotton T-Shirt', 12.99, 'Soft cotton tee for everyday wear.', 'clothing', 'https://picsum.photos/seed/p1/400/400', 4.3, 120),
('Slim-Fit Jeans', 35.50, 'Stretch denim, tapered leg.', 'clothing', 'https://picsum.photos/seed/p2/400/400', 4.5, 220),
('Hoodie Oversize', 28.90, 'Cozy fleece-lined hoodie.', 'clothing', 'https://picsum.photos/seed/p3/400/400', 4.2, 89),
('Wireless Earbuds', 49.99, 'Bluetooth 5.3, 24h battery with case.', 'electronics', 'https://picsum.photos/seed/p4/400/400', 4.4, 510),
('Mechanical Keyboard', 79.00, 'Hot-swap switches, RGB backlight.', 'electronics', 'https://picsum.photos/seed/p5/400/400', 4.6, 310),
('Gaming Mouse', 29.95, '8K DPI, programmable buttons.', 'electronics', 'https://picsum.photos/seed/p6/400/400', 4.1, 180),
('Stainless Water Bottle 1L', 16.50, 'Keeps drinks cold 24h, hot 12h.', 'home', 'https://picsum.photos/seed/p7/400/400', 4.7, 95),
('Ceramic Mug 350ml', 7.99, 'Dishwasher and microwave safe.', 'home', 'https://picsum.photos/seed/p8/400/400', 4.3, 210),
('Memory Foam Pillow', 22.00, 'Ergonomic neck support.', 'home', 'https://picsum.photos/seed/p9/400/400', 4.0, 67),
('Backpack 25L', 31.75, 'Water-resistant, laptop sleeve.', 'accessories', 'https://picsum.photos/seed/p10/400/400', 4.5, 133),
('Leather Belt', 18.40, 'Full-grain leather, matte buckle.', 'accessories', 'https://picsum.photos/seed/p11/400/400', 4.2, 54),
('Sunglasses UV400', 21.90, 'Polarized lenses.', 'accessories', 'https://picsum.photos/seed/p12/400/400', 4.6, 160),
('Yoga Mat 6mm', 19.99, 'Non-slip TPE, carry strap.', 'sports', 'https://picsum.photos/seed/p13/400/400', 4.4, 97),
('Dumbbell Set 10kg', 45.00, 'Adjustable plates.', 'sports', 'https://picsum.photos/seed/p14/400/400', 4.1, 41),
('Running Shoes', 59.90, 'Breathable mesh upper.', 'sports', 'https://picsum.photos/seed/p15/400/400', 4.3, 205),
('Desk LED Lamp', 24.50, '3 color temps, USB-C.', 'home', 'https://picsum.photos/seed/p16/400/400', 4.5, 72),
('Portable SSD 1TB', 109.00, 'USB-C 10Gbps, shock-resistant.', 'electronics', 'https://picsum.photos/seed/p17/400/400', 4.8, 420),
('4K Monitor 27"', 269.00, 'IPS, 60Hz, HDR10.', 'electronics', 'https://picsum.photos/seed/p18/400/400', 4.4, 156),
('Office Chair', 139.00, 'Lumbar support, tilt lock.', 'home', 'https://picsum.photos/seed/p19/400/400', 4.2, 88),
('Action Camera', 189.00, '4K60, waterproof case included.', 'electronics', 'https://picsum.photos/seed/p20/400/400', 4.5, 312);