<?php
declare(strict_types=1);

function e(mixed $value): string { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function redirect(string $url): never { header('Location: ' . $url); exit; }
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
function csrf_field(): string { return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">'; }
function verify_csrf(): void {
    $sent = $_POST['csrf_token'] ?? '';
    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
        http_response_code(419); exit('Сұрау мерзімі аяқталды немесе CSRF токені жарамсыз. Бетті жаңартып көріңіз.');
    }
}
function is_logged_in(): bool { return isset($_SESSION['user']['id']); }
function money(mixed $amount): string { return number_format((float)$amount, 0, '.', ' ') . ' ₸'; }
function image_url(?string $url): string {
    $url = trim((string)$url);
    return filter_var($url, FILTER_VALIDATE_URL) && in_array(parse_url($url, PHP_URL_SCHEME), ['http','https'], true)
        ? $url : '';
}
function product_image(array $product, string $class = 'product-image'): string {
    $src = image_url($product['image'] ?? '');
    $alt = e($product['name'] ?? 'Өнім суреті');
    return '<img class="' . e($class) . ' js-fallback-image" src="' . e($src) . '" alt="' . $alt . '" loading="lazy" data-fallback="true">';
}
