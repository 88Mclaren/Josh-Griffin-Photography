<?php
require_once __DIR__ . '/config.php';
$pageTitle='Contact';
$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $name=trim($_POST['name']??''); $email=trim($_POST['email']??'');
    $subject=trim($_POST['subject']??''); $message=trim($_POST['message']??'');
    if ($name==='' || strlen($name)>120) $errors[]='Please enter your name.';
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]='Please enter a valid email address.';
    if ($subject==='' || strlen($subject)>180) $errors[]='Please enter a subject.';
    if ($message==='' || strlen($message)>10000) $errors[]='Please enter a message (maximum 10,000 characters).';
    if (!$errors) {
        $stmt=db()->prepare('INSERT INTO contact_messages (name,email,subject,message) VALUES (?,?,?,?)');
        $stmt->execute([$name,$email,$subject,$message]);
        flash('Thank you! Your message has been received.');
        redirect('contact.php');
    }
}
require __DIR__.'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">CONTACT</p><h1>Let's talk photography.</h1><p>Tell me a little about what you have in mind.</p></section>
<section class="form-section">
<?php foreach($errors as $error): ?><div class="notice error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="form-card">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Your name<input name="name" maxlength="120" required value="<?= e($_POST['name']??'') ?>"></label>
<label>Email address<input type="email" name="email" required value="<?= e($_POST['email']??'') ?>"></label>
<label>Subject<input name="subject" maxlength="180" required value="<?= e($_POST['subject']??'') ?>"></label>
<label>Message<textarea name="message" rows="7" maxlength="10000" required><?= e($_POST['message']??'') ?></textarea></label>
<button class="button" type="submit">Send message</button>
</form></section>
<?php require __DIR__.'/includes/footer.php'; ?>
