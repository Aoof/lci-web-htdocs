# Student Task Manager

Single-user Student Task Manager built with PHP, PDO, MySQL, and an MVC-inspired structure.

## Features
- Add a task
- Display all tasks
- Edit existing tasks
- Delete tasks
- Filter tasks by status and course
- Server-side validation and prepared statements

## Project Structure
- config/dbConfig.php: PDO configuration and connection factory
- models/Task.php: task data access (CRUD + filters)
- controllers/TaskController.php: request handling and validation
- views/task_list.php: list and filters
- views/task_create.php: create form
- views/task_edit.php: edit form
- database/schema.sql: MySQL schema
- public/style.css: styling
- index.php: front controller and action router

## Setup (XAMPP)
1. Start Apache and MySQL in XAMPP.
2. Open phpMyAdmin and import database/schema.sql.
3. Confirm credentials in config/dbConfig.php (defaults are root with empty password for local XAMPP).
4. Open the app in browser: http://localhost/exercises/franck-projet-final/

## Notes
- Allowed priorities: Low, Medium, High
- Allowed statuses: Pending, In Progress, Completed
