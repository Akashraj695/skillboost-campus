<?php
require_once "config.php"; require_login(); $u=current_user();
$student=$pdo->query("SELECT * FROM users WHERE role='student' ORDER BY id LIMIT 1")->fetch();
$reg=$pdo->prepare("SELECT COUNT(*) c FROM registrations WHERE user_id=? AND status='registered'");$reg->execute([$student['id']]);$reg=$reg->fetch()['c'];
$done=$pdo->prepare("SELECT COUNT(*) c FROM registrations WHERE user_id=? AND status='completed'");$done->execute([$student['id']]);$done=$done->fetch()['c'];
$skills=$pdo->prepare("SELECT * FROM skills WHERE user_id=? ORDER BY progress DESC");$skills->execute([$student['id']]);$skills=$skills->fetchAll();
?>
<?php $page_title="Parent Dashboard"; include "header.php"; ?>
<div class="hero"><div><span class="eyebrow">PARENT VIEW</span><h1><?=htmlspecialchars($student['name'])?>'s growth</h1><p>Support skill development alongside academics.</p></div></div>
<div class="stats"><div class="stat"><span>Workshops registered</span><b><?=$reg?></b></div><div class="stat"><span>Completed</span><b><?=$done?></b></div><div class="stat"><span>Career goal</span><b><?=htmlspecialchars($student['career_goal'])?></b></div></div>
<div class="card"><h2>Skills</h2><?php foreach($skills as $s):?><div class="skill-row"><div><b><?=htmlspecialchars($s['skill_name'])?></b><span><?=$s['progress']?>%</span></div><div class="progress"><i style="width:<?=$s['progress']?>%"></i></div></div><?php endforeach;?></div>
<?php include "footer.php"; ?>
