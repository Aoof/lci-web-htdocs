CREATE DATABASE IF NOT EXISTS student_task_manager
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;

USE student_task_manager;

CREATE TABLE IF NOT EXISTS tasks (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	course VARCHAR(100) NOT NULL,
	description TEXT NULL,
	due_date DATE NOT NULL,
	priority VARCHAR(20) NOT NULL,
	status VARCHAR(20) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX idx_tasks_status (status),
	INDEX idx_tasks_course (course),
	INDEX idx_tasks_due_date (due_date)
);
