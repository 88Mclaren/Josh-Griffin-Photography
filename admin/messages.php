<?php
require_once dirname(__DIR__).'/config.php';require_admin();
if(isset($_GET['read'])){$id=(int)$_GET['read'];$s=db()->prepare('UPDATE contact_messages SET is_read=1 WHERE id=?');$s->execute([$id]);redirect('admin/messages.php');}
$messages=db()->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();$pageTitle='Contact Messages';require dirname(__DIR__).'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">ADMIN</p><h1>Contact messages</h1></section><section class="section admin-section">
<?php foreach($messages as $m): ?><article class="message-card"><div class="message-meta"><strong><?= e($m['subject']) ?></strong><span><?= e($m['created_at']) ?> · <?= $m['is_read']?'Read':'Unread' ?></span></div><p><strong><?= e($m['name']) ?></strong> — <?= e($m['email']) ?></p><p><?= nl2br(e($m['message'])) ?></p><?php if(!$m['is_read']): ?><a class="text-link" href="<?= e(url('admin/messages.php?read='.(int)$m['id'])) ?>">Mark as read</a><?php endif; ?></article><?php endforeach; ?>
<?php if(!$messages): ?><p>No messages yet.</p><?php endif; ?></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
