<?php
declare(strict_types=1);
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'Apple Store — технология мен дизайн';
$cartCount = array_sum(array_map('intval', $_SESSION['cart'] ?? []));
?>
<!doctype html>
<html lang="kk"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Apple өнімдеріне арналған оқу жобасы — минималистік цифрлық дүкен.">
<title><?= e($pageTitle) ?></title><link rel="preconnect" href="https://www.apple.com"><link rel="stylesheet" href="assets/css/style.css"></head>
<body><header class="site-header"><div class="nav-wrap"><a class="brand" href="index.php" aria-label="Басты бет"></a>
<button class="menu-toggle" type="button" aria-expanded="false" aria-label="Мәзірді ашу">☰</button>
<nav class="main-nav" aria-label="Негізгі навигация"><a href="index.php">Басты бет</a><a href="products.php">Өнімдер</a><a href="about.php">Компания туралы</a><a href="contact.php">Байланыс</a></nav>
<div class="account-nav"><?php if (is_logged_in()): ?><span class="nav-user"><?= e($_SESSION['user']['name']) ?></span><a href="profile.php">Кабинет</a><a href="cart.php">Себет <span class="cart-count"><?= $cartCount ?></span></a><form action="logout.php" method="post" class="inline-form"><?= csrf_field() ?><button class="nav-link" type="submit">Шығу</button></form><?php else: ?><a href="login.php">Кіру</a><a class="nav-register" href="register.php">Тіркелу</a><?php endif; ?></div></div></header><main>
