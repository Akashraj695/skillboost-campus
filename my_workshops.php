<?php
require_once "config.php"; require_login(); $u=current_user();
if(isset($_GET['cancel'])){$pdo->prepare("UPDATE registrations SET status='cancelled' WHERE user_id=? AND workshop_id=?")->execute([$u['id'],(int)$_GET['cancel']]);header("Location: my_workshops.php");exit;}
$stmt=$pdo->prepare("SELECT w.*,r.status,r.registered_at FROM registrations r JOIN workshops w ON w.id=r.workshop_id WHERE r.user_id=? ORDER BY w.workshop_date DESC");$stmt->execute([$u['id']]);$items=$stmt->fetchAll();
?>
<?php $page_title="My Workshops"; include "header.php"; ?>
<div class="section-head"><h1>My workshops</h1><a class="btn primary" href="workshops.php">+ Discover more</a></div>
<div class="table-wrap"><table><tr><th>Workshop</th><th>Date</th><th>Category</th><th>Status</th><th>Action</th></tr>
<?php foreach($items as $x): ?><tr><td><b><?=htmlspecialchars($x['title'])?></b></td><td><?=date('d M Y',strtotime($x['workshop_date']))?></td><td><?=htmlspecialchars($x['category'])?></td><td><span class="status"><?=$x['status']?></span></td><td><?php if($x['status']==='registered'):?><a href="?cancel=<?=$x['id']?>" class="danger-link" data-confirm="Cancel this registration?">Cancel</a><?php endif;?></td></tr><?php endforeach;?>
</table></div>
<?php include "footer.php"; ?>
