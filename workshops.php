<?php
require_once "config.php"; require_login();
$u=current_user();
$q=trim($_GET['q']??''); $cat=trim($_GET['category']??'');
$sql="SELECT w.*, (SELECT COUNT(*) FROM registrations r WHERE r.workshop_id=w.id AND r.status='registered') enrolled,
(SELECT COUNT(*) FROM registrations r2 WHERE r2.workshop_id=w.id AND r2.user_id=? AND r2.status='registered') mine
FROM workshops w WHERE w.workshop_date>=CURDATE()";
$params=[$u['id']];
if($q){$sql.=" AND (w.title LIKE ? OR w.description LIKE ? OR w.trainer LIKE ?)"; $like="%$q%"; array_push($params,$like,$like,$like);}
if($cat){$sql.=" AND w.category=?";$params[]=$cat;}
$sql.=" ORDER BY w.workshop_date,w.start_time";
$stmt=$pdo->prepare($sql);$stmt->execute($params);$workshops=$stmt->fetchAll();
if(isset($_GET['register'])){
    $wid=(int)$_GET['register'];
    $pdo->prepare("INSERT IGNORE INTO registrations(user_id,workshop_id) VALUES(?,?)")->execute([$u['id'],$wid]);
    header("Location: workshops.php?msg=registered");exit;
}
?>
<?php $page_title="Workshops"; include "header.php"; ?>
<div class="section-head"><div><span class="eyebrow">DISCOVER</span><h1>Campus workshops</h1></div></div>
<form class="filterbar" method="get">
<input name="q" value="<?=htmlspecialchars($q)?>" placeholder="Search workshops, skills, trainers...">
<select name="category"><option value="">All categories</option><?php foreach(['Technical','Soft Skills','Placement','Leadership'] as $c): ?><option <?=$cat===$c?'selected':''?>><?=$c?></option><?php endforeach;?></select>
<button class="btn primary">Search</button>
</form>
<?php if(isset($_GET['msg'])):?><div class="alert success">Workshop registration updated successfully.</div><?php endif;?>
<div class="cards">
<?php foreach($workshops as $w): ?>
<div class="card workshop-card">
<span class="tag"><?=htmlspecialchars($w['category'])?></span>
<h3><?=htmlspecialchars($w['title'])?></h3>
<p><?=htmlspecialchars($w['description'])?></p>
<p><b>Trainer:</b> <?=htmlspecialchars($w['trainer'])?></p>
<p>📅 <?=date('D, d M Y',strtotime($w['workshop_date']))?><br>⏰ <?=date('g:i A',strtotime($w['start_time']))?> – <?=date('g:i A',strtotime($w['end_time']))?></p>
<div class="seat">Seats: <?=max(0,$w['seats']-$w['enrolled'])?> remaining</div>
<?php if($w['mine']): ?><button class="btn disabled" disabled>✓ Registered</button>
<?php elseif($w['enrolled'] >= $w['seats']): ?><button class="btn disabled" disabled>Full</button>
<?php else: ?><a class="btn primary" href="?register=<?=$w['id']?>">Register now</a><?php endif;?>
</div>
<?php endforeach; ?>
</div>
<?php include "footer.php"; ?>
