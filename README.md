# SkillBoost Campus

A working PHP + MySQL campus skill-development website.

## Features
- Student registration/login with PHP sessions
- Student dashboard using the logged-in user's actual details
- Workshop listing and search/filter
- Workshop registration with duplicate prevention
- My Workshops page
- Personal weekly planner
- Skill progress tracking
- Parent dashboard
- Teacher dashboard
- Admin dashboard for adding workshops
- Responsive HTML/CSS/JavaScript UI

## Requirements
- XAMPP (Apache + MySQL) or another PHP/MySQL server
- PHP 8+
- MySQL/MariaDB

## Setup in XAMPP
1. Copy the `skillboost_campus` folder into `C:\xampp\htdocs\`
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin and import `database.sql`.
4. Visit:
   http://localhost/skillboost_campus/

## Demo accounts
After importing database.sql:
- Student: priya@example.com / password
- Parent: parent@example.com / password
- Teacher: teacher@example.com / password
- Admin: admin@example.com / password

For a real deployment, replace these demo passwords and add proper password hashing for seeded users.

## Main pages
- index.php - login
- register.php - student registration
- dashboard.php - role-aware dashboard
- workshops.php - discover/register
- my_workshops.php - registered workshops
- planner.php - personal planner
- progress.php - skills/progress
- logout.php
- parent_dashboard.php
- teacher_dashboard.php
- admin.php
