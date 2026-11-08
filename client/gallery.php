<?php
require_once dirname(__DIR__).'/config.php'; $user=require_login(); $id=(int)($_GET['id']??0);
$stmt=db()->prepare('SELECT g.* FROM galleries g JOIN gallery_clients gc ON gc.gallery_id=g.id WHERE g.id=? AND gc.user_id=?');
$stmt->execute([$id,$user['id']]); $gallery=$stmt->fetch();
if(!$gallery){http_response_code(404);exit('Gallery not found.');}
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$photo=(int)($_POST['photo_id']??0);
    $check=db()->prepare('SELECT id FROM photos WHERE id=? AND gallery_id=?');$check->execute([$photo,$id]);
    if($check->fetch()){
        $exists=db()->prepare('SELECT id FROM favorites WHERE user_id=? AND photo_id=?');
        $exists->execute([$user['id'],$photo]);
        if($exists->fetch()){$del=db()->prepare('DELETE FROM favorites WHERE user_id=? AND photo_id=?');$del->execute([$user['id'],$photo]);}
        else{$ins=db()->prepare('INSERT IGNORE INTO favorites(user_id,photo_id) VALUES(?,?)');$ins->execute([$user['id'],$photo]);}
        flash('Your favorites have been updated.'); redirect('client/gallery.php?id='.$id);
    }
}
$q=db()->prepare('SELECT p.id,p.caption, (f.id IS NOT NULL) AS is_favorite FROM photos p LEFT JOIN favorites f ON f.photo_id=p.id AND f.user_id=? WHERE p.gallery_id=? ORDER BY p.created_at');
$q->execute([$user['id'],$id]);$photos=$q->fetchAll();
$pageTitle=$gallery['title']; require dirname(__DIR__).'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">PRIVATE GALLERY</p><h1><?= e($gallery['title']) ?></h1><p><?= e($gallery['description']) ?></p><p><a class="text-link" href="<?= e(url('client/dashboard.php')) ?>">← Back to my galleries</a></p></section>
<section class="section"><div class="photo-grid">
<?php foreach($photos as $p): ?><article class="photo-card"><a href="<?= e(photo_url((int)$p['id'])) ?>" target="_blank"><img src="<?= e(photo_url((int)$p['id'])) ?>" alt="<?= e($p['caption'] ?: 'Gallery photograph') ?>" loading="lazy"></a>
<p><?= e($p['caption']) ?></p><form method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="photo_id" value="<?= (int)$p['id'] ?>"><button class="favorite-button" type="submit"><?= $p['is_favorite']?'♥ Favorited':'♡ Add to favorites' ?></button></form></article><?php endforeach; ?>
</div><?php if(!$photos): ?><p>Photos will appear here once the gallery is ready.</p><?php endif; ?></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
