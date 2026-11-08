<?php
require_once dirname(__DIR__).'/config.php'; require_admin(); $errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$name=trim($_POST['name']??'');$email=strtolower(trim($_POST['email']??''));$password=$_POST['password']??'';
 if($name===''||strlen($name)>120)$errors[]='Enter a client name.';
 if(!filter_var($email,FILTER_VALIDATE_EMAIL))$errors[]='Enter a valid email.';
 if(strlen($password)<12)$errors[]='Temporary password must be at least 12 characters.';
 if(!$errors){try{$s=db()->prepare("INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,'client')");$s->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);flash('Client account created. Share the login details securely.');redirect('admin/clients.php');}catch(PDOException $ex){$errors[]='That email address may already be registered.';}}
}
$clients=db()->query("SELECT id,name,email,created_at FROM users WHERE role='client' ORDER BY created_at DESC")->fetchAll();$pageTitle='Manage Clients';require dirname(__DIR__).'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">ADMIN</p><h1>Clients</h1></section><section class="section admin-section">
<h2>Create a client account</h2><?php foreach($errors as $x): ?><div class="notice error"><?= e($x) ?></div><?php endforeach; ?>
<form method="post" class="form-card compact-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><label>Client name<input name="name" required maxlength="120"></label><label>Email<input type="email" name="email" required></label><label>Temporary password (12+ characters)<input type="password" name="password" minlength="12" required></label><button class="button">Create client</button></form>
<h2>Existing clients</h2><div class="table-wrap"><table><thead><tr><th>Name</th><th>Email</th><th>Created</th></tr></thead><tbody><?php foreach($clients as $c): ?><tr><td><?= e($c['name']) ?></td><td><?= e($c['email']) ?></td><td><?= e($c['created_at']) ?></td></tr><?php endforeach; ?></tbody></table></div></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
