<?php
require_once "config.php"; require_login();
$u=current_user();
if($u['role']==='parent'){ header("Location: parent_dashboard.php"); exit; }
if($u['role']==='teacher'){ header("Location: teacher_dashboard.php"); exit; }
if($u['role']==='admin'){ header("Location: admin.php"); exit; }

$skills=$pdo->prepare("SELECT * FROM skills WHERE user_id=? ORDER BY progress DESC"); $skills->execute([$u['id']]); $skills=$skills->fetchAll();
$registered=$pdo->prepare("SELECT COUNT(*) c FROM registrations WHERE user_id=? AND status='registered'"); $registered->execute([$u['id']]); $registered=(int)$registered->fetch()['c'];
$completed=$pdo->prepare("SELECT COUNT(*) c FROM registrations WHERE user_id=? AND status='completed'"); $completed->execute([$u['id']]); $completed=(int)$completed->fetch()['c'];
$avg=0; if(count($skills)){foreach($skills as $s)$avg+=$s['progress'];$avg=round($avg/count($skills));}
$up=$pdo->query("SELECT * FROM workshops WHERE workshop_date>=CURDATE() ORDER BY workshop_date,start_time LIMIT 3")->fetchAll();
?>
<?php $page_title="Dashboard"; include "header.php"; ?>
<div class="hero">
  <div><span class="eyebrow">STUDENT DASHBOARD</span>
  <h1>Hi, <?=htmlspecialchars($u['name'])?> 👋</h1>
  <p>Build skills around your academic schedule.</p></div>
  <div class="profile-chip"><?=htmlspecialchars($u['branch'])?> • Year <?=htmlspecialchars($u['year_level'])?></div>
</div>

<div class="stats">
<div class="stat"><span>Skill progress</span><b><?=$avg?>%</b></div>
<div class="stat"><span>Registered</span><b><?=$registered?></b></div>
<div class="stat"><span>Completed</span><b><?=$completed?></b></div>
<div class="stat"><span>Career goal</span><b><?=htmlspecialchars($u['career_goal'])?></b></div>
</div>

<div class="section-head"><h2>Recommended for you</h2><a href="workshops.php">View all →</a></div>
<div class="cards">
<?php foreach($up as $w): ?>
<div class="card">
  <span class="tag"><?=htmlspecialchars($w['category'])?></span>
  <h3><?=htmlspecialchars($w['title'])?></h3>
  <p><?=htmlspecialchars($w['description'])?></p>
  <small>📅 <?=date('d M Y',strtotime($w['workshop_date']))?> &nbsp; ⏰ <?=date('g:i A',strtotime($w['start_time']))?></small>
  <a class="btn outline" href="workshops.php">View & Register</a>
</div>
<?php endforeach; ?>
</div>

<div class="section-head"><h2>Your skill growth</h2><a href="progress.php">Manage skills →</a></div>
<div class="skill-list">
<?php foreach($skills as $s): ?>
<div class="skill-row"><div><b><?=htmlspecialchars($s['skill_name'])?></b><span><?=$s['progress']?>%</span></div><div class="progress"><i style="width:<?=$s['progress']?>%"></i></div></div>
<?php endforeach; ?>
</div>
<?php include "footer.php"; ?>
