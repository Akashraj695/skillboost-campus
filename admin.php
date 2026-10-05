<?php
require_once "config.php"; require_login(); $u=current_user();
if($u['role']!=='admin'){http_response_code(403);die("Access denied");}
$msg="";
if($_SERVER['REQUEST_METHOD']==='POST'){
 $stmt=$pdo->prepare("INSERT INTO workshops(title,category,description,trainer,workshop_date,start_time,end_time,seats) VALUES(?,?,?,?,?,?,?,?)");
 $stmt->execute([trim($_POST['title']),$_POST['category'],trim($_POST['description']),trim($_POST['trainer']),$_POST['workshop_date'],$_POST['start_time'],$_POST['end_time'],(int)$_POST['seats']]);
 $msg="Workshop created.";
}
?>
<?php $page_title="Admin"; include "header.php"; ?>
<div class="section-head"><div><span class="eyebrow">ADMIN</span><h1>Manage campus training</h1></div></div>
<?php if($msg):?><div class="alert success"><?=$msg?></div><?php endif;?>
<div class="card"><h2>Create workshop</h2><form method="post" class="grid2">
<div><label>Title</label><input name="title" required></div><div><label>Category</label><select name="category"><option>Technical</option><option>Soft Skills</option><option>Placement</option><option>Leadership</option></select></div>
<div class="full-field"><label>Description</label><textarea name="description" required></textarea></div><div><label>Trainer</label><input name="trainer" required></div><div><label>Seats</label><input type="number" name="seats" value="30" min="1"></div>
<div><label>Date</label><input type="date" name="workshop_date" required></div><div><label>Start</label><input type="time" name="start_time" required></div><div><label>End</label><input type="time" name="end_time" required></div>
<button class="btn primary">Publish Workshop</button>
</form></div>
<?php include "footer.php"; ?>
