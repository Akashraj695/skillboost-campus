<?php
require_once "config.php";
if(isset($_SESSION['user'])) { header("Location: dashboard.php"); exit; }
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email']??'');
    $password=$_POST['password']??'';
    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    $u=$stmt->fetch();
    if($u && $u['password']===$password){
        $_SESSION['user']=$u;
        header("Location: dashboard.php"); exit;
    }
    $error="Invalid email or password.";
}
?>
<?php $page_title="Login"; include "header.php"; ?>
<div class="auth-card">
  <div class="logo-circle">SB</div>
  <h1>Welcome back</h1>
  <p class="muted">Turn campus opportunities into career-ready skills.</p>
  <?php if($error): ?><div class="alert error"><?=htmlspecialchars($error)?></div><?php endif; ?>
  <form method="post">
    <label>Email</label><input type="email" name="email" required placeholder="you@example.com">
    <label>Password</label><input type="password" name="password" required>
    <button class="btn primary full">Login</button>
  </form>
  <p class="center">New student? <a href="register.php">Create account</a></p>
  <div class="demo">
    <b>Demo:</b> priya@example.com / password
  </div>
</div>
<?php include "footer.php"; ?>
