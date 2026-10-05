<?php
require_once "config.php"; require_login(); $u=current_user();
$total=$pdo->query("SELECT COUNT(*) c FROM users WHERE role='student'")->fetch()['c'];
$regs=$pdo->query("SELECT COUNT(*) c FROM registrations WHERE status='registered'")->fetch()['c'];
$workshops=$pdo->query("SELECT * FROM workshops ORDER BY workshop_date DESC")->fetchAll();
?>
<?php $page_title="Teacher Dashboard"; include "header.php"; ?>
<div class="hero"><div><span class="eyebrow">TEACHER / MENTOR</span><h1>Training monitor</h1><p>Track participation and campus skill programs.</p></div></div>
<div class="stats"><div class="stat"><span>Students</span><b><?=$total?></b></div><div class="stat"><span>Active registrations</span><b><?=$regs?></b></div><div class="stat"><span>Workshops</span><b><?=count($workshops)?></b></div></div>
<div class="table-wrap"><table><tr><th>Workshop</th><th>Date</th><th>Category</th><th>Trainer</th></tr><?php foreach($workshops as $w):?><tr><td><?=htmlspecialchars($w['title'])?></td><td><?=date('d M Y',strtotime($w['workshop_date']))?></td><td><?=htmlspecialchars($w['category'])?></td><td><?=htmlspecialchars($w['trainer'])?></td></tr><?php endforeach;?></table></div>
<?php include "footer.php"; ?>
