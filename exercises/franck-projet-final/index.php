<?php

declare(strict_types=1);

session_start();

define('BASE_PATH', __DIR__);
define('VIEW_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'views');

require BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'dbConfig.php';
require BASE_PATH . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Task.php';
require BASE_PATH . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'TaskController.php';

$action = $_GET['action'] ?? 'list';

$routeMap = [
	'list' => 'list',
	'create' => 'create',
	'store' => 'store',
	'edit' => 'edit',
	'update' => 'update',
	'delete' => 'delete',
];

if (!isset($routeMap[$action])) {
	http_response_code(404);
	echo 'Invalid action.';
	exit;
}

try {
	$taskModel = new Task(DBConfig::getConnection());
	$controller = new TaskController($taskModel);
	$method = $routeMap[$action];
	$controller->{$method}();
} catch (Throwable $exception) {
	http_response_code(500);
	echo 'Application error: ' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8');
}
