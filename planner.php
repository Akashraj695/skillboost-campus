<?php
require_once "config.php"; require_login(); $u=current_user();
$msg="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 $stmt=$pdo->prepare("INSERT INTO planner(user_id,task_title,task_date,start_time,end_time,task_type) VALUES(?,?,?,?,?,?)");
 $stmt->execute([$u['id'],trim($_POST['task_title']),$_POST['task_date'],$_POST['start_time'],$_POST['end_time'],$_POST['task_type']]);$msg="Task added to your planner.";
}
if(isset($_GET['delete'])){$pdo->prepare("DELETE FROM planner WHERE id=? AND user_id=?")->execute([(int)$_GET['delete'],$u['id']]);header("Location: planner.php");exit;}
$tasks=$pdo->prepare("SELECT * FROM planner WHERE user_id=? ORDER BY task_date,start_time");$tasks->execute([$u['id']]);$tasks=$tasks->fetchAll();
?>
<?php $page_title="Planner"; include "header.php"; ?>
<div class="section-head"><div><span class="eyebrow">TIME MANAGEMENT</span><h1>My weekly planner</h1></div></div>
<?php if($msg):?><div class="alert success"><?=$msg?></div><?php endif;?>
<div class="two-col">
<div class="card">
<h2>Add a task</h2><form method="post">
<label>Task</label><input name="task_title" placeholder="Java practice" required>
<label>Date</label><input type="date" name="task_date" required>
<div class="grid2"><div><label>Start</label><input type="time" name="start_time" required></div><div><label>End</label><input type="time" name="end_time" required></div></div>
<label>Type</label><select name="task_type"><option>Study</option><option>Workshop</option><option>Project</option><option>Personal</option></select>
<button class="btn primary full">Add to planner</button></form>
</div>
<div class="card"><h2>Upcoming tasks</h2>
<?php foreach($tasks as $t):?><div class="task"><div><b><?=htmlspecialchars($t['task_title'])?></b><small><?=date('d M Y',strtotime($t['task_date']))?> • <?=date('g:i A',strtotime($t['start_time']))?>–<?=date('g:i A',strtotime($t['end_time']))?></small></div><a href="?delete=<?=$t['id']?>" class="danger-link">×</a></div><?php endforeach;?>
</div></div>
<?php include "footer.php"; ?>
