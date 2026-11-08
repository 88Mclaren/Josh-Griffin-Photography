<?php
$pageTitle = $pageTitle ?? 'Josh Griffin Photography';
$user = current_user();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Josh Griffin Photography — event and portrait photography.">
  <title><?= e($pageTitle) ?> | Josh Griffin Photography</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(url('assets/css/styles.css')) ?>">
  <script src="<?= e(url('assets/js/script.js')) ?>" defer></script>
</head>
<body>
<header class="site-header">
  <a class="brand" href="<?= e(url('index.php')) ?>">Josh Griffin <span>Photography</span></a>
  <button class="menu-toggle" aria-expanded="false" aria-controls="main-nav">Menu</button>
  <nav id="main-nav" class="main-nav">
    <a href="<?= e(url('index.php')) ?>">Home</a>
    <div class="nav-dropdown">
      <button class="dropdown-toggle" aria-expanded="false">Portfolio</button>
      <div class="dropdown-menu">
        <a href="<?= e(url('events.php')) ?>">Events</a>
        <a href="<?= e(url('portraits.php')) ?>">Portraits</a>
      </div>
    </div>
    <a href="<?= e(url('about.php')) ?>">About</a>
    <a href="<?= e(url('contact.php')) ?>">Contact</a>
    <?php if ($user): ?>
      <a href="<?= e(url($user['role'] === 'admin' ? 'admin/dashboard.php' : 'client/dashboard.php')) ?>">My Account</a>
      <a href="<?= e(url('logout.php')) ?>">Log out</a>
    <?php else: ?>
      <a href="<?= e(url('login.php')) ?>">Client Login</a>
    <?php endif; ?>
  </nav>
</header>
<main class="site-main">
<?php show_flash(); ?>
