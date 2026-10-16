<?php
declare(strict_types=1);

$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbName = getenv('DB_NAME') ?: 'apple_store';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '';
$dbCharset = 'utf8mb4';
$preferredDriver = strtolower(getenv('DB_DRIVER') ?: 'mysql');
$allowSqliteFallback = getenv('DB_FALLBACK_SQLITE') !== '0';

try {
    if (!in_array($preferredDriver, ['mysql', 'sqlite'], true)) {
        throw new RuntimeException('DB_DRIVER must be mysql or sqlite.');
    }

    $pdoOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    if ($preferredDriver === 'sqlite') {
        $pdo = open_sqlite_store($pdoOptions);
    } else {
        try {
            $dsn = "mysql:host={$dbHost};dbname={$dbName};charset={$dbCharset}";
            $pdo = new PDO($dsn, $dbUser, $dbPass, $pdoOptions);
        } catch (PDOException $mysqlError) {
            if (!$allowSqliteFallback || !in_array((int)$mysqlError->getCode(), [2002, 2003, 2006, 2013], true)) {
                throw $mysqlError;
            }
            $pdo = open_sqlite_store($pdoOptions);
        }
    }
} catch (Throwable $e) {
    http_response_code(500);
    exit('Дерекқорға қосылу мүмкін болмады. MySQL немесе SQLite параметрлерін тексеріңіз.');
}

function open_sqlite_store(array $pdoOptions): PDO
{
    if (!in_array('sqlite', PDO::getAvailableDrivers(), true)) {
        throw new RuntimeException('PDO SQLite extension is not installed.');
    }

    $sqlitePath = getenv('DB_SQLITE_PATH');
    if (!$sqlitePath) {
        $basePath = getenv('APPDATA') ?: (getenv('HOME') ? getenv('HOME') . DIRECTORY_SEPARATOR . '.local' . DIRECTORY_SEPARATOR . 'share' : sys_get_temp_dir());
        $dataDirectory = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'apple-store';
        if (!is_dir($dataDirectory) && !mkdir($dataDirectory, 0700, true) && !is_dir($dataDirectory)) {
            throw new RuntimeException('Unable to create the SQLite data directory.');
        }
        $sqlitePath = $dataDirectory . DIRECTORY_SEPARATOR . 'apple-store.sqlite';
    } else {
        $customDirectory = dirname($sqlitePath);
        if (!is_dir($customDirectory) && !mkdir($customDirectory, 0700, true) && !is_dir($customDirectory)) {
            throw new RuntimeException('Unable to create the configured SQLite directory.');
        }
    }

    $pdo = new PDO('sqlite:' . $sqlitePath, null, null, $pdoOptions);
    $pdo->exec('PRAGMA foreign_keys = ON');
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(120) NOT NULL,
        email VARCHAR(190) NOT NULL COLLATE NOCASE UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(160) NOT NULL UNIQUE,
        category VARCHAR(60) NOT NULL,
        description TEXT NOT NULL,
        price DECIMAL(12,2) NOT NULL,
        image VARCHAR(1000) NOT NULL,
        stock INTEGER NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )");
    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(120) NOT NULL,
        email VARCHAR(190) NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )");

    $seedProducts = [
        ['iPhone 17 Pro', 'iPhone', 'Жоғары өнімділік, кәсіби камера жүйесі және берік алюминий корпус.', 649990, 'https://www.apple.com/v/iphone/home/ck/images/overview/priority-router/hero_iphone_duo__wqpt8bqwtfm2_large.jpg', 12],
        ['iPhone 17', 'iPhone', 'Күнделікті түсірілім мен байланысқа арналған заманауи смартфон.', 499990, 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?auto=format&fit=crop&w=1200&q=85', 18],
        ['MacBook Air', 'MacBook', 'Жеңіл әрі ықшам ноутбук. Оқу, жұмыс және шығармашылыққа қолайлы.', 599990, 'https://www.apple.com/v/macbook-air/z/images/overview/hero/hero_static__c9sislzzicq6_large.png', 8],
        ['MacBook Pro', 'MacBook', 'Күрделі жобаларға арналған қуатты ноутбук және сапалы дисплей.', 999990, 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=85', 6],
        ['iPad Air', 'iPad', 'Икемді планшет, сенсорлы экран және шығармашылыққа арналған кеңістік.', 399990, 'https://www.apple.com/v/ipad-air/ah/images/overview/hero/hero_endframe__6gl84bccyaqi_large.png', 10],
        ['iPad Pro', 'iPad', 'Үлкен экран мен дәл басқару мүмкіндігін қажет ететін кәсіби жұмысқа.', 649990, 'https://www.apple.com/v/ipad-air/ah/images/overview/contrast/product-tile/ipadpro13_gen7_camera__l4y3lk14hsqe_large.png', 5],
        ['Apple Watch Series', 'Apple Watch', 'Белсенділік, уақыт және хабарландырулар бір білекте.', 199990, 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?auto=format&fit=crop&w=1200&q=85', 14],
        ['Apple Watch Ultra', 'Apple Watch', 'Сыртқы белсенділік пен төзімділікке арналған смарт сағат.', 349990, 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?auto=format&fit=crop&w=1200&q=85', 4],
        ['AirPods Pro', 'AirPods', 'Сымсыз құлаққап, белсенді шуды басу және ыңғайлы қаптама.', 149990, 'https://www.apple.com/v/airpods-pro/t/images/overview/welcome/hero__b0eal3mn03ua_large.jpg', 20],
        ['AirPods 4', 'AirPods', 'Жеңіл сымсыз құлаққап, сапалы дыбыс және ықшам дизайн.', 89990, 'https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?auto=format&fit=crop&w=1200&q=85', 16],
    ];
    $insertProduct = $pdo->prepare('INSERT OR IGNORE INTO products (name, category, description, price, image, stock) VALUES (:name, :category, :description, :price, :image, :stock)');
    foreach ($seedProducts as $product) {
        $insertProduct->execute([
            'name' => $product[0], 'category' => $product[1], 'description' => $product[2],
            'price' => $product[3], 'image' => $product[4], 'stock' => $product[5],
        ]);
    }

    return $pdo;
}
