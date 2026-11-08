<?php
require_once dirname(__DIR__).'/config.php'; $user=require_login();
if($user['role']==='admin') redirect('admin/dashboard.php');
$pageTitle='My Galleries';
$stmt=db()->prepare('SELECT g.* FROM galleries g JOIN gallery_clients gc ON gc.gallery_id=g.id WHERE gc.user_id=? ORDER BY g.created_at DESC');
$stmt->execute([$user['id']]); $galleries=$stmt->fetchAll();
require dirname(__DIR__).'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">CLIENT AREA</p><h1>Hello, <?= e($user['name']) ?>.</h1><p>Your private photography galleries.</p></section>
<section class="section"><h2>Your galleries</h2><div class="dashboard-grid">
<?php foreach($galleries as $g): ?><a class="dashboard-card" href="<?= e(url('client/gallery.php?id='.(int)$g['id'])) ?>"><span class="eyebrow">PRIVATE GALLERY</span><h3><?= e($g['title']) ?></h3><p><?= e($g['description']) ?></p><span class="text-link">Open gallery →</span></a><?php endforeach; ?>
<?php if(!$galleries): ?><p>No galleries have been assigned to your account yet.</p><?php endif; ?>
</div></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
