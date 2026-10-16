<?php
require_once __DIR__ . '/includes/functions.php';
if (session_status() !== PHP_SESSION_ACTIVE) { session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']),'samesite'=>'Lax']); session_start(); }
require_once __DIR__ . '/config/database.php';
$pageTitle = 'Apple Store — жаңа буын технологиясы';
$featured = $pdo->query('SELECT id,name,category,description,price,image,stock FROM products ORDER BY id ASC LIMIT 4')->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="hero hero-home"><div class="hero-copy"><p class="eyebrow">ЖАҢА ӨНІМДЕР. ЖАҢА МҮМКІНДІКТЕР.</p><h1>Технология<br>саған жақын.</h1><p>Күнделікті сәттерге арналған мұқият жасалған құрылғылармен таныс.</p><a class="button button-dark" href="products.php">Өнімдерді қарау <span>→</span></a></div><div class="hero-art hero-phone" aria-hidden="true"><div class="phone-device"><span></span><i></i><b></b></div></div></section>
<section class="category-strip"><a href="products.php?category=iPhone">iPhone</a><a href="products.php?category=MacBook">MacBook</a><a href="products.php?category=iPad">iPad</a><a href="products.php?category=Apple+Watch">Watch</a><a href="products.php?category=AirPods">AirPods</a></section>
<section class="section section-pad"><div class="section-heading"><div><p class="eyebrow">ТАҢДАУЛЫ ҰСЫНЫСТАР</p><h2>Жаңа өнімдер.</h2></div><a class="text-link" href="products.php">Барлығын көру →</a></div><div class="product-grid home-grid"><?php foreach ($featured as $product): ?><article class="product-card"><a class="product-visual" href="product.php?id=<?= (int)$product['id'] ?>"><?= product_image($product) ?><span class="image-placeholder"></span></a><div class="product-info"><p class="eyebrow"><?= e($product['category']) ?></p><h3><a href="product.php?id=<?= (int)$product['id'] ?>"><?= e($product['name']) ?></a></h3><p class="product-desc"><?= e($product['description']) ?></p><div class="product-bottom"><strong><?= money($product['price']) ?></strong><a class="button button-small" href="product.php?id=<?= (int)$product['id'] ?>">Толығырақ</a></div></div></article><?php endforeach; ?></div></section>
<section class="feature-band"><div><p class="eyebrow">ҚАРАПАЙЫМДЫҚТЫҢ КҮШІ</p><h2>Әр бөлшекте<br>ойластырылған.</h2><p>Технология, дизайн және қолайлылық бір кеңістікте.</p><a class="text-link" href="about.php">Жоба туралы →</a></div><div class="feature-orb" aria-hidden="true"><span></span></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
