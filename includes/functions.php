<?php
declare(strict_types=1);

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function url(string $path = ''): string {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}
function redirect(string $path): never {
    header('Location: ' . url($path));
    exit;
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    $token = $_POST['csrf'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('Your session expired. Please go back, refresh, and try again.');
    }
}
function current_user(): ?array {
    if (empty($_SESSION['user_id'])) return null;
    $stmt = db()->prepare('SELECT id, name, email, role FROM users WHERE id = ? AND is_active = 1');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    if (!$user) { unset($_SESSION['user_id']); return null; }
    return $user;
}
function require_login(): array {
    $user = current_user();
    if (!$user) redirect('login.php');
    return $user;
}
function require_admin(): array {
    $user = require_login();
    if ($user['role'] !== 'admin') { http_response_code(403); exit('Access denied.'); }
    return $user;
}
function flash(string $message, string $type = 'success'): void {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}
function show_flash(): void {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash']; unset($_SESSION['flash']);
        echo '<div class="notice ' . e($f['type']) . '">' . e($f['message']) . '</div>';
    }
}
function photo_url(int $id): string { return url('photo.php?id=' . $id); }
function ensure_upload_dir(): void {
    if (!is_dir(UPLOAD_DIR) && !mkdir(UPLOAD_DIR, 0750, true) && !is_dir(UPLOAD_DIR)) {
        throw new RuntimeException('Could not create private upload directory.');
    }
}
