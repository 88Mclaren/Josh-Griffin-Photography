<?php
require_once dirname(__DIR__).'/config.php'; require_admin(); $id=(int)($_GET['id']??0);
$s=db()->prepare('SELECT * FROM galleries WHERE id=?');$s->execute([$id]);$gallery=$s->fetch();if(!$gallery){http_response_code(404);exit('Gallery not found.');}
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$caption=trim($_POST['caption']??'');$file=$_FILES['photo']??null;
 if(!$file||$file['error']!==UPLOAD_ERR_OK)$errors[]='Choose a photo to upload.';
 elseif($file['size']>MAX_UPLOAD_BYTES)$errors[]='Photo is larger than the 15 MB limit.';
 else{
  $finfo=new finfo(FILEINFO_MIME_TYPE);$mime=$finfo->file($file['tmp_name']);
  $allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
  if(!isset($allowed[$mime])||@getimagesize($file['tmp_name'])===false)$errors[]='Only valid JPG, PNG, and WebP images are allowed.';
  else{try{ensure_upload_dir();$stored=bin2hex(random_bytes(24)).'.'.$allowed[$mime];$dest=UPLOAD_DIR.'/'.$stored;
    if(!move_uploaded_file($file['tmp_name'],$dest))throw new RuntimeException('Upload failed.');
    $ins=db()->prepare('INSERT INTO photos(gallery_id,filename,caption,mime_type,filesize) VALUES(?,?,?,?,?)');
    $ins->execute([$id,$stored,$caption,$mime,(int)$file['size']]);flash('Photograph uploaded.');redirect('admin/gallery.php?id='.$id);
   }catch(Throwable $e){$errors[]='The upload could not be saved. Check your private upload folder permissions.';}
  }
 }
}
$photos=db()->prepare('SELECT id,caption,created_at FROM photos WHERE gallery_id=? ORDER BY created_at DESC');$photos->execute([$id]);$rows=$photos->fetchAll();
$pageTitle='Manage Gallery';require dirname(__DIR__).'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">ADMIN / GALLERY</p><h1><?= e($gallery['title']) ?></h1><p><a class="text-link" href="<?= e(url('admin/galleries.php')) ?>">← All galleries</a></p></section>
<section class="section admin-section"><h2>Upload a photograph</h2><?php foreach($errors as $x): ?><div class="notice error"><?= e($x) ?></div><?php endforeach; ?>
<form method="post" enctype="multipart/form-data" class="form-card compact-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Image (JPG, PNG, WebP; max 15 MB)<input type="file" name="photo" accept="image/jpeg,image/png,image/webp" required></label><label>Caption<input name="caption" maxlength="255"></label><button class="button">Upload photo</button></form>
<h2>Photographs (<?= count($rows) ?>)</h2><div class="photo-grid"><?php foreach($rows as $p): ?><article class="photo-card"><img src="<?= e(photo_url((int)$p['id'])) ?>" alt="<?= e($p['caption']?:'Gallery photo') ?>"><p><?= e($p['caption']) ?></p></article><?php endforeach; ?></div></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
