CREATE DATABASE IF NOT EXISTS apple_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE apple_store;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS products (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(160) NOT NULL,
  category VARCHAR(60) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(12,2) NOT NULL,
  image VARCHAR(1000) NOT NULL,
  stock INT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_products_name (name),
  KEY idx_products_category (category),
  KEY idx_products_name (name)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

INSERT INTO products (name, category, description, price, image, stock) VALUES
('iPhone 17 Pro', 'iPhone', 'Жоғары өнімділік, кәсіби камера жүйесі және берік алюминий корпус.', 649990, 'https://www.apple.com/v/iphone/home/ck/images/overview/priority-router/hero_iphone_duo__wqpt8bqwtfm2_large.jpg', 12),
('iPhone 17', 'iPhone', 'Күнделікті түсірілім мен байланысқа арналған заманауи смартфон.', 499990, 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?auto=format&fit=crop&w=1200&q=85', 18),
('MacBook Air', 'MacBook', 'Жеңіл әрі ықшам ноутбук. Оқу, жұмыс және шығармашылыққа қолайлы.', 599990, 'https://www.apple.com/v/macbook-air/z/images/overview/hero/hero_static__c9sislzzicq6_large.png', 8),
('MacBook Pro', 'MacBook', 'Күрделі жобаларға арналған қуатты ноутбук және сапалы дисплей.', 999990, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=85', 6),
('iPad Air', 'iPad', 'Икемді планшет, сенсорлы экран және шығармашылыққа арналған кеңістік.', 399990, 'https://www.apple.com/v/ipad-air/ah/images/overview/hero/hero_endframe__6gl84bccyaqi_large.png', 10),
('iPad Pro', 'iPad', 'Үлкен экран мен дәл басқару мүмкіндігін қажет ететін кәсіби жұмысқа.', 649990, 'https://www.apple.com/v/ipad-air/ah/images/overview/contrast/product-tile/ipadpro13_gen7_camera__l4y3lk14hsqe_large.png', 5),
('Apple Watch Series', 'Apple Watch', 'Белсенділік, уақыт және хабарландырулар бір білекте.', 199990, 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?auto=format&fit=crop&w=1200&q=85', 14),
('Apple Watch Ultra', 'Apple Watch', 'Сыртқы белсенділік пен төзімділікке арналған смарт сағат.', 349990, 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?auto=format&fit=crop&w=1200&q=85', 4),
('AirPods Pro', 'AirPods', 'Сымсыз құлаққап, белсенді шуды басу және ыңғайлы қаптама.', 149990, 'https://www.apple.com/v/airpods-pro/t/images/overview/welcome/hero__b0eal3mn03ua_large.jpg', 20),
('AirPods 4', 'AirPods', 'Жеңіл сымсыз құлаққап, сапалы дыбыс және ықшам дизайн.', 89990, 'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?auto=format&fit=crop&w=1200&q=85', 16)
ON DUPLICATE KEY UPDATE name=VALUES(name);
