<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Task List', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <main class="container">
        <?php
        $tasks = $tasks ?? [];
        $courses = $courses ?? [];
        $selectedStatus = $selectedStatus ?? '';
        $selectedCourse = $selectedCourse ?? '';
        $allowedStatuses = $allowedStatuses ?? [];
        $flash = $flash ?? null;
        ?>

        <h1><?php echo htmlspecialchars($pageTitle ?? 'Task List', ENT_QUOTES, 'UTF-8'); ?></h1>

        <?php if (is_array($flash) && isset($flash['type'], $flash['text'])): ?>
            <div class="flash <?php echo $flash['type'] === 'success' ? 'flash-success' : 'flash-error'; ?>">
                <?php echo htmlspecialchars((string) $flash['text'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <section class="panel">
            <h2>Filters</h2>
            <form action="index.php" method="get" class="filter-grid">
                <input type="hidden" name="action" value="list">

                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">All statuses</option>
                    <?php foreach ($allowedStatuses as $statusOption): ?>
                        <option value="<?php echo htmlspecialchars($statusOption, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedStatus === $statusOption ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($statusOption, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="course">Course</label>
                <select id="course" name="course">
                    <option value="">All courses</option>
                    <?php foreach ($courses as $courseOption): ?>
                        <option value="<?php echo htmlspecialchars((string) $courseOption, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedCourse === (string) $courseOption ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars((string) $courseOption, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="filter-actions">
                    <button type="submit">Apply Filters</button>
                    <a class="button-secondary" href="index.php?action=list">Reset</a>
                </div>
            </form>
        </section>

        <div class="toolbar">
            <a class="button-primary" href="index.php?action=create">Add Task</a>
        </div>

        <section class="panel">
            <h2>Tasks</h2>
            <?php if ($tasks === []): ?>
                <p>No tasks found. Add your first task.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Course</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars((string) $task['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) $task['course'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) $task['due_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) $task['priority'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) $task['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) $task['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <a href="index.php?action=edit&id=<?php echo (int) $task['id']; ?>">Edit</a>
                                        <form action="index.php?action=delete" method="post" class="inline-form" onsubmit="return confirm('Delete this task?');">
                                            <input type="hidden" name="id" value="<?php echo (int) $task['id']; ?>">
                                            <button type="submit" class="button-link danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
