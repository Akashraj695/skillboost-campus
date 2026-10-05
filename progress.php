<?php
require_once "config.php"; require_login(); $u=current_user();
if($_SERVER['REQUEST_METHOD']==='POST'){
 $skill=trim($_POST['skill_name']);$progress=max(0,min(100,(int)$_POST['progress']));
 $pdo->prepare("INSERT INTO skills(user_id,skill_name,progress) VALUES(?,?,?) ON DUPLICATE KEY UPDATE progress=VALUES(progress)")->execute([$u['id'],$skill,$progress]);
}
$skills=$pdo->prepare("SELECT * FROM skills WHERE user_id=? ORDER BY progress DESC");$skills->execute([$u['id']]);$skills=$skills->fetchAll();
?>
<?php $page_title="Progress"; include "header.php"; ?>
<div class="section-head"><div><span class="eyebrow">GROWTH</span><h1>Skill progress</h1></div></div>
<div class="card">
<form method="post" class="inline-form"><input name="skill_name" placeholder="Skill name" required><input type="number" min="0" max="100" name="progress" placeholder="0-100" required><button class="btn primary">Save skill</button></form>
</div>
<div class="skill-list large">
<?php foreach($skills as $s):?><div class="skill-row"><div><b><?=htmlspecialchars($s['skill_name'])?></b><span><?=$s['progress']?>%</span></div><div class="progress"><i style="width:<?=$s['progress']?>%"></i></div></div><?php endforeach;?>
</div>
<?php include "footer.php"; ?>
