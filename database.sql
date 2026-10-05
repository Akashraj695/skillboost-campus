CREATE DATABASE IF NOT EXISTS skillboost_campus;
USE skillboost_campus;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS workshops;
DROP TABLE IF EXISTS planner;
DROP TABLE IF EXISTS skills;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','parent','teacher','admin') NOT NULL DEFAULT 'student',
    branch VARCHAR(100) DEFAULT NULL,
    year_level INT DEFAULT NULL,
    career_goal VARCHAR(150) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE workshops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    description TEXT NOT NULL,
    trainer VARCHAR(100) NOT NULL,
    workshop_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    seats INT NOT NULL DEFAULT 30,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    workshop_id INT NOT NULL,
    status ENUM('registered','completed','cancelled') DEFAULT 'registered',
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_registration (user_id, workshop_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (workshop_id) REFERENCES workshops(id) ON DELETE CASCADE
);

CREATE TABLE planner (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    task_title VARCHAR(150) NOT NULL,
    task_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    task_type VARCHAR(50) NOT NULL DEFAULT 'Study',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    progress INT NOT NULL DEFAULT 0,
    UNIQUE KEY unique_user_skill (user_id, skill_name),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (name,email,password,role,branch,year_level,career_goal) VALUES
('Priya','priya@example.com','password','student','Computer Science',3,'Full Stack Developer'),
('Priya Parent','parent@example.com','password','parent',NULL,NULL,NULL),
('Dr. Ravi Kumar','teacher@example.com','password','teacher','Computer Science',NULL,NULL),
('Admin User','admin@example.com','password','admin',NULL,NULL,NULL);

INSERT INTO workshops (title,category,description,trainer,workshop_date,start_time,end_time,seats) VALUES
('Full-Stack Web Development','Technical','Build a responsive web application and learn frontend/backend integration.','Anil Kumar','2026-10-05','10:00:00','13:00:00',40),
('Resume & LinkedIn Lab','Placement','Create a strong student resume and improve your professional profile.','Career Cell','2026-10-08','14:00:00','16:00:00',50),
('Public Speaking Confidence','Soft Skills','Practice communication, presentation and interview confidence.','Meena Rao','2026-10-12','11:00:00','13:00:00',30),
('Python for Data Skills','Technical','Learn practical Python concepts for data-oriented projects.','Suresh B','2026-10-15','10:00:00','13:00:00',35),
('Leadership Bootcamp','Leadership','Develop teamwork, decision-making and leadership skills.','Student Development Cell','2026-10-20','09:30:00','12:30:00',30);

INSERT INTO skills (user_id,skill_name,progress) VALUES
(1,'Java',65),(1,'Web Development',40),(1,'Communication',55),(1,'Problem Solving',70);
