<?php
require_once dirname(__DIR__).'/config.php'; $user=require_login();
$q=db()->prepare('SELECT p.id,p.caption,g.title FROM favorites f JOIN photos p ON p.id=f.photo_id JOIN galleries g ON g.id=p.gallery_id JOIN gallery_clients gc ON gc.gallery_id=g.id WHERE f.user_id=? AND gc.user_id=? ORDER BY f.created_at DESC');
$q->execute([$user['id'],$user['id']]);$photos=$q->fetchAll();$pageTitle='My Favorites';require dirname(__DIR__).'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">CLIENT AREA</p><h1>My favorites</h1></section><section class="section"><div class="photo-grid">
<?php foreach($photos as $p): ?><article class="photo-card"><a href="<?= e(photo_url((int)$p['id'])) ?>"><img src="<?= e(photo_url((int)$p['id'])) ?>" alt="<?= e($p['caption']?:'Favorite photograph') ?>"></a><p><?= e($p['title']) ?> — <?= e($p['caption']) ?></p></article><?php endforeach; ?>
</div><?php if(!$photos): ?><p>You haven't favorited any photographs yet.</p><?php endif; ?></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
