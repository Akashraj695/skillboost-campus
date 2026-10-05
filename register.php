<?php
require_once "config.php";
if(isset($_SESSION['user'])) { header("Location: dashboard.php"); exit; }
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??''); $email=trim($_POST['email']??'');
    $password=$_POST['password']??''; $branch=trim($_POST['branch']??'');
    $year=(int)($_POST['year_level']??3); $goal=trim($_POST['career_goal']??'');
    if(!$name || !$email || !$password || !$branch || !$goal) $error="Please complete all fields.";
    else {
        try {
            $stmt=$pdo->prepare("INSERT INTO users(name,email,password,role,branch,year_level,career_goal) VALUES(?,?,?,?,?,?,?)");
            $stmt->execute([$name,$email,$password,'student',$branch,$year,$goal]);
            $id=$pdo->lastInsertId();
            $pdo->prepare("INSERT INTO skills(user_id,skill_name,progress) VALUES(?,?,?)")->execute([$id,'Communication',10]);
            $pdo->prepare("INSERT INTO skills(user_id,skill_name,progress) VALUES(?,?,?)")->execute([$id,'Problem Solving',10]);
            header("Location: index.php"); exit;
        } catch(PDOException $e){ $error="Email already exists."; }
    }
}
?>
<?php $page_title="Register"; include "header.php"; ?>
<div class="auth-card wide">
<h1>Create your student account</h1>
<p class="muted">Your recommendations will be based on your profile.</p>
<?php if($error): ?><div class="alert error"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" class="grid2">
<div><label>Full name</label><input name="name" required></div>
<div><label>Email</label><input type="email" name="email" required></div>
<div><label>Password</label><input type="password" name="password" required></div>
<div><label>Branch</label><input name="branch" placeholder="Computer Science" required></div>
<div><label>Year</label><select name="year_level"><option>1</option><option>2</option><option selected>3</option><option>4</option></select></div>
<div><label>Career goal</label><input name="career_goal" placeholder="Full Stack Developer" required></div>
</div>
<button class="btn primary full">Create Account</button>
</form>
</div>
<?php include "footer.php"; ?>
