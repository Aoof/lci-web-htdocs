<?php

declare(strict_types=1);

final class TaskController
{
    public const ALLOWED_PRIORITIES = ['Low', 'Medium', 'High'];
    public const ALLOWED_STATUSES = ['Pending', 'In Progress', 'Completed'];

    private Task $taskModel;

    public function __construct(Task $taskModel)
    {
        $this->taskModel = $taskModel;
    }

    public function list(): void
    {
        $selectedStatus = isset($_GET['status']) ? trim((string) $_GET['status']) : '';
        $selectedCourse = isset($_GET['course']) ? trim((string) $_GET['course']) : '';

        if ($selectedStatus !== '' && !in_array($selectedStatus, self::ALLOWED_STATUSES, true)) {
            $selectedStatus = '';
        }

        $tasks = $this->taskModel->getAll(
            $selectedStatus !== '' ? $selectedStatus : null,
            $selectedCourse !== '' ? $selectedCourse : null
        );

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        $this->render('task_list', [
            'pageTitle' => 'Task List',
            'tasks' => $tasks,
            'courses' => $this->taskModel->getCourses(),
            'selectedStatus' => $selectedStatus,
            'selectedCourse' => $selectedCourse,
            'allowedStatuses' => self::ALLOWED_STATUSES,
            'flash' => $flash,
        ]);
    }

    public function create(): void
    {
        $this->render('task_create', [
            'pageTitle' => 'Create Task',
            'errors' => [],
            'task' => $this->getDefaultTaskValues(),
            'allowedPriorities' => self::ALLOWED_PRIORITIES,
            'allowedStatuses' => self::ALLOWED_STATUSES,
        ]);
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=create');
        }

        $taskData = $this->sanitizeTaskData($_POST);
        $errors = $this->validateTaskData($taskData);

        if ($errors !== []) {
            $this->render('task_create', [
                'pageTitle' => 'Create Task',
                'errors' => $errors,
                'task' => $taskData,
                'allowedPriorities' => self::ALLOWED_PRIORITIES,
                'allowedStatuses' => self::ALLOWED_STATUSES,
            ]);
            return;
        }

        $this->taskModel->create($taskData);
        $_SESSION['flash'] = [
            'type' => 'success',
            'text' => 'Task created successfully.',
        ];

        $this->redirect('index.php?action=list');
    }

    public function edit(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id <= 0) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'text' => 'Invalid task ID.',
            ];
            $this->redirect('index.php?action=list');
        }

        $task = $this->taskModel->getById($id);

        if ($task === null) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'text' => 'Task not found.',
            ];
            $this->redirect('index.php?action=list');
        }

        $this->render('task_edit', [
            'pageTitle' => 'Edit Task',
            'errors' => [],
            'task' => $task,
            'allowedPriorities' => self::ALLOWED_PRIORITIES,
            'allowedStatuses' => self::ALLOWED_STATUSES,
        ]);
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=list');
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null || $id <= 0) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'text' => 'Invalid task ID.',
            ];
            $this->redirect('index.php?action=list');
        }

        $existing = $this->taskModel->getById($id);
        if ($existing === null) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'text' => 'Task not found.',
            ];
            $this->redirect('index.php?action=list');
        }

        $taskData = $this->sanitizeTaskData($_POST);
        $errors = $this->validateTaskData($taskData);

        if ($errors !== []) {
            $taskData['id'] = $id;
            $this->render('task_edit', [
                'pageTitle' => 'Edit Task',
                'errors' => $errors,
                'task' => $taskData,
                'allowedPriorities' => self::ALLOWED_PRIORITIES,
                'allowedStatuses' => self::ALLOWED_STATUSES,
            ]);
            return;
        }

        $this->taskModel->update($id, $taskData);
        $_SESSION['flash'] = [
            'type' => 'success',
            'text' => 'Task updated successfully.',
        ];

        $this->redirect('index.php?action=list');
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?action=list');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id <= 0) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'text' => 'Invalid task ID.',
            ];
            $this->redirect('index.php?action=list');
        }

        $this->taskModel->delete($id);
        $_SESSION['flash'] = [
            'type' => 'success',
            'text' => 'Task deleted successfully.',
        ];

        $this->redirect('index.php?action=list');
    }

    private function getDefaultTaskValues(): array
    {
        return [
            'title' => '',
            'course' => '',
            'description' => '',
            'due_date' => '',
            'priority' => 'Medium',
            'status' => 'Pending',
        ];
    }

    private function sanitizeTaskData(array $input): array
    {
        return [
            'title' => trim((string) ($input['title'] ?? '')),
            'course' => trim((string) ($input['course'] ?? '')),
            'description' => trim((string) ($input['description'] ?? '')),
            'due_date' => trim((string) ($input['due_date'] ?? '')),
            'priority' => trim((string) ($input['priority'] ?? '')),
            'status' => trim((string) ($input['status'] ?? '')),
        ];
    }

    private function validateTaskData(array $taskData): array
    {
        $errors = [];

        if ($taskData['title'] === '') {
            $errors[] = 'Title is required.';
        }

        if ($taskData['course'] === '') {
            $errors[] = 'Course is required.';
        }

        if ($taskData['due_date'] === '') {
            $errors[] = 'Due date is required.';
        } elseif (!$this->isValidDate($taskData['due_date'])) {
            $errors[] = 'Due date must be a valid date.';
        }

        if (!in_array($taskData['priority'], self::ALLOWED_PRIORITIES, true)) {
            $errors[] = 'Priority is invalid.';
        }

        if (!in_array($taskData['status'], self::ALLOWED_STATUSES, true)) {
            $errors[] = 'Status is invalid.';
        }

        return $errors;
    }

    private function isValidDate(string $date): bool
    {
        $parts = date_parse($date);
        return $parts['error_count'] === 0
            && $parts['warning_count'] === 0
            && checkdate((int) $parts['month'], (int) $parts['day'], (int) $parts['year']);
    }

    private function render(string $viewName, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require VIEW_PATH . DIRECTORY_SEPARATOR . $viewName . '.php';
    }

    private function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}
