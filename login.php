<?php
require_once __DIR__ . '/config.php';
if (current_user()) { $u=current_user(); redirect($u['role']==='admin'?'admin/dashboard.php':'client/dashboard.php'); }
$pageTitle='Client Login'; $error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $email=strtolower(trim($_POST['email']??'')); $password=$_POST['password']??'';
    $stmt=db()->prepare('SELECT id,password_hash FROM users WHERE email=? AND is_active=1 LIMIT 1');
    $stmt->execute([$email]); $row=$stmt->fetch();
    if ($row && password_verify($password,$row['password_hash'])) {
        session_regenerate_id(true); $_SESSION['user_id']=(int)$row['id'];
        $u=current_user(); redirect($u['role']==='admin'?'admin/dashboard.php':'client/dashboard.php');
    }
    $error='The email or password was incorrect.';
}
require __DIR__.'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">PRIVATE CLIENT AREA</p><h1>Welcome back.</h1><p>Sign in to view your private photographs.</p></section>
<section class="form-section"><form method="post" class="form-card">
<?php if($error): ?><div class="notice error"><?= e($error) ?></div><?php endif; ?>
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Email address<input type="email" name="email" autocomplete="username" required></label>
<label>Password<input type="password" name="password" autocomplete="current-password" required></label>
<button class="button" type="submit">Log in</button>
</form></section>
<?php require __DIR__.'/includes/footer.php'; ?>
