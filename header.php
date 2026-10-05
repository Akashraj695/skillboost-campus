<?php require_once "config.php"; $u=current_user(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title ?? 'SkillBoost Campus') ?></title>
<link rel="stylesheet" href="assets/style.css">
<script defer src="assets/app.js"></script>
</head>
<body>
<header class="topbar">
  <a class="brand" href="dashboard.php">Skill<span>Boost</span></a>
  <?php if($u): ?>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <?php if($u['role']==='student'): ?>
      <a href="workshops.php">Workshops</a>
      <a href="my_workshops.php">My Workshops</a>
      <a href="planner.php">Planner</a>
      <a href="progress.php">Progress</a>
    <?php elseif($u['role']==='parent'): ?>
      <a href="parent_dashboard.php">Student Overview</a>
    <?php elseif($u['role']==='teacher'): ?>
      <a href="teacher_dashboard.php">Training Monitor</a>
    <?php elseif($u['role']==='admin'): ?>
      <a href="admin.php">Admin</a>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
  </nav>
  <?php endif; ?>
</header>
<main class="container">
