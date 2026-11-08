<?php
require_once dirname(__DIR__).'/config.php'; require_admin(); $errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$title=trim($_POST['title']??'');$desc=trim($_POST['description']??'');$client=(int)($_POST['client_id']??0);
 $c=db()->prepare("SELECT id FROM users WHERE id=? AND role='client' AND is_active=1");$c->execute([$client]);
 if($title===''||strlen($title)>180)$errors[]='Enter a gallery title.';
 if(!$c->fetch())$errors[]='Choose a valid client.';
 if(!$errors){$pdo=db();$pdo->beginTransaction();try{$s=$pdo->prepare('INSERT INTO galleries(title,description,created_by) VALUES(?,?,?)');$s->execute([$title,$desc, $_SESSION['user_id']]);$gid=(int)$pdo->lastInsertId();$a=$pdo->prepare('INSERT INTO gallery_clients(gallery_id,user_id) VALUES(?,?)');$a->execute([$gid,$client]);$pdo->commit();flash('Gallery created. You can now upload photographs.');redirect('admin/gallery.php?id='.$gid);}catch(Throwable $e){$pdo->rollBack();$errors[]='Could not create gallery.';}}
}
$clients=db()->query("SELECT id,name,email FROM users WHERE role='client' AND is_active=1 ORDER BY name")->fetchAll();
$galleries=db()->query('SELECT g.id,g.title,g.created_at,u.name client_name,(SELECT COUNT(*) FROM photos p WHERE p.gallery_id=g.id) photo_count FROM galleries g LEFT JOIN gallery_clients gc ON gc.gallery_id=g.id LEFT JOIN users u ON u.id=gc.user_id ORDER BY g.created_at DESC')->fetchAll();
$pageTitle='Manage Galleries';require dirname(__DIR__).'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">ADMIN</p><h1>Galleries</h1></section><section class="section admin-section">
<h2>Create a private gallery</h2><?php foreach($errors as $x): ?><div class="notice error"><?= e($x) ?></div><?php endforeach; ?>
<form method="post" class="form-card compact-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Gallery title<input name="title" maxlength="180" required></label><label>Description<textarea name="description" rows="3"></textarea></label><label>Assign to client<select name="client_id" required><option value="">Select a client</option><?php foreach($clients as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['name'].' — '.$c['email']) ?></option><?php endforeach; ?></select></label><button class="button" <?= !$clients?'disabled':'' ?>>Create gallery</button><?php if(!$clients): ?><p>Create a client account first.</p><?php endif; ?></form>
<h2>Existing galleries</h2><div class="dashboard-grid"><?php foreach($galleries as $g): ?><a class="dashboard-card" href="<?= e(url('admin/gallery.php?id='.(int)$g['id'])) ?>"><h3><?= e($g['title']) ?></h3><p>Client: <?= e($g['client_name']??'Unassigned') ?> · <?= (int)$g['photo_count'] ?> photos</p><span class="text-link">Manage →</span></a><?php endforeach; ?></div></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
