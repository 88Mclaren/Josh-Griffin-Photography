<?php
require_once dirname(__DIR__).'/config.php'; $admin=require_admin(); $pageTitle='Admin Dashboard';
$counts=['clients'=>db()->query("SELECT COUNT(*) FROM users WHERE role='client'")->fetchColumn(),'galleries'=>db()->query('SELECT COUNT(*) FROM galleries')->fetchColumn(),'photos'=>db()->query('SELECT COUNT(*) FROM photos')->fetchColumn(),'messages'=>db()->query('SELECT COUNT(*) FROM contact_messages WHERE is_read=0')->fetchColumn()];
require dirname(__DIR__).'/includes/header.php';
?>
<section class="page-hero"><p class="eyebrow">ADMINISTRATION</p><h1>Dashboard</h1><p>Manage clients, galleries, and photography content.</p></section>
<section class="section"><div class="stats-grid">
<?php foreach($counts as $label=>$count): ?><div class="stat-card"><strong><?= (int)$count ?></strong><span><?= e(ucfirst($label)) ?></span></div><?php endforeach; ?>
</div><div class="admin-links"><a class="dashboard-card" href="<?= e(url('admin/clients.php')) ?>"><h3>Manage clients</h3><p>Create client accounts and assign galleries.</p></a><a class="dashboard-card" href="<?= e(url('admin/galleries.php')) ?>"><h3>Manage galleries</h3><p>Create galleries and upload photographs.</p></a><a class="dashboard-card" href="<?= e(url('admin/messages.php')) ?>"><h3>Contact messages</h3><p>Read inquiries submitted through the website.</p></a></div></section>
<?php require dirname(__DIR__).'/includes/footer.php'; ?>
