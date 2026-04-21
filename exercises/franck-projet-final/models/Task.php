<?php

declare(strict_types=1);

final class Task
{
	private PDO $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getAll(?string $status = null, ?string $course = null): array
	{
		$sql = 'SELECT id, title, course, description, due_date, priority, status, created_at FROM tasks';
		$conditions = [];
		$params = [];

		if ($status !== null && $status !== '') {
			$conditions[] = 'status = :status';
			$params[':status'] = $status;
		}

		if ($course !== null && $course !== '') {
			$conditions[] = 'course = :course';
			$params[':course'] = $course;
		}

		if ($conditions !== []) {
			$sql .= ' WHERE ' . implode(' AND ', $conditions);
		}

		$sql .= ' ORDER BY due_date ASC, id DESC';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);

		return $stmt->fetchAll();
	}

	public function getById(int $id): ?array
	{
		$stmt = $this->pdo->prepare(
			'SELECT id, title, course, description, due_date, priority, status, created_at FROM tasks WHERE id = :id LIMIT 1'
		);
		$stmt->execute([':id' => $id]);
		$task = $stmt->fetch();

		return $task === false ? null : $task;
	}

	public function create(array $task): bool
	{
		$stmt = $this->pdo->prepare(
			'INSERT INTO tasks (title, course, description, due_date, priority, status)
			 VALUES (:title, :course, :description, :due_date, :priority, :status)'
		);

		return $stmt->execute([
			':title' => $task['title'],
			':course' => $task['course'],
			':description' => $task['description'],
			':due_date' => $task['due_date'],
			':priority' => $task['priority'],
			':status' => $task['status'],
		]);
	}

	public function update(int $id, array $task): bool
	{
		$stmt = $this->pdo->prepare(
			'UPDATE tasks
			 SET title = :title,
				 course = :course,
				 description = :description,
				 due_date = :due_date,
				 priority = :priority,
				 status = :status
			 WHERE id = :id'
		);

		return $stmt->execute([
			':id' => $id,
			':title' => $task['title'],
			':course' => $task['course'],
			':description' => $task['description'],
			':due_date' => $task['due_date'],
			':priority' => $task['priority'],
			':status' => $task['status'],
		]);
	}

	public function delete(int $id): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = :id');
		return $stmt->execute([':id' => $id]);
	}

	public function getCourses(): array
	{
		$stmt = $this->pdo->query('SELECT DISTINCT course FROM tasks WHERE course <> "" ORDER BY course ASC');
		return $stmt->fetchAll(PDO::FETCH_COLUMN);
	}
}
