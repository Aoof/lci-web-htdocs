<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Create Task', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <main class="container">
        <?php
        $task = $task ?? [];
        $errors = $errors ?? [];
        $allowedPriorities = $allowedPriorities ?? [];
        $allowedStatuses = $allowedStatuses ?? [];
        ?>

        <h1><?php echo htmlspecialchars($pageTitle ?? 'Create Task', ENT_QUOTES, 'UTF-8'); ?></h1>

        <?php if ($errors !== []): ?>
            <div class="flash flash-error">
                <strong>Please fix the following:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="panel">
            <form action="index.php?action=store" method="post" class="form-grid">
                <label for="title">Title *</label>
                <input id="title" name="title" type="text" maxlength="255" required value="<?php echo htmlspecialchars((string) ($task['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

                <label for="course">Course *</label>
                <input id="course" name="course" type="text" maxlength="100" required value="<?php echo htmlspecialchars((string) ($task['course'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars((string) ($task['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></textarea>

                <label for="due_date">Due Date *</label>
                <input id="due_date" name="due_date" type="date" required value="<?php echo htmlspecialchars((string) ($task['due_date'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

                <label for="priority">Priority *</label>
                <select id="priority" name="priority" required>
                    <?php foreach ($allowedPriorities as $priority): ?>
                        <option value="<?php echo htmlspecialchars($priority, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($task['priority'] ?? '') === $priority ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($priority, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <?php foreach ($allowedStatuses as $status): ?>
                        <option value="<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($task['status'] ?? '') === $status ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="form-actions">
                    <button type="submit">Save Task</button>
                    <a class="button-secondary" href="index.php?action=list">Cancel</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
