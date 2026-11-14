<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
function money(float|int|string $amount): string {
    return CURRENCY . number_format((float)$amount, 2);
}
function redirect(string $path): never {
    header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
    exit;
}
function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
function get_flash(): ?array {
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
            http_response_code(403);
            exit('Invalid request token. Please go back and try again.');
        }
    }
}
function is_logged_in(): bool { return !empty($_SESSION['user_id']); }
function require_login(): void {
    if (!is_logged_in()) {
        set_flash('warning', 'Please log in to continue.');
        redirect('auth/login.php');
    }
}
function is_admin(): bool { return ($_SESSION['role'] ?? '') === 'admin'; }
function require_admin(): void {
    if (!is_admin()) {
        set_flash('warning', 'Admin access required.');
        redirect('admin/login.php');
    }
}
function cart_count(): int {
    return array_sum($_SESSION['cart'] ?? []);
}
function cart_items(PDO $pdo): array {
    $cart = $_SESSION['cart'] ?? [];
    if (!$cart) return [];
    $ids = array_map('intval', array_keys($cart));
    $marks = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE id IN ($marks) AND is_available = 1");
    $stmt->execute($ids);
    $items = $stmt->fetchAll();
    foreach ($items as &$item) {
        $item['quantity'] = max(1, (int)($cart[$item['id']] ?? 1));
        $item['line_total'] = $item['price'] * $item['quantity'];
    }
    return $items;
}
