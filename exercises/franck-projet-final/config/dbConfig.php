<?php

declare(strict_types=1);

final class DBConfig
{
    public const HOST = '127.0.0.1';
    public const PORT = '3306';
    public const DB_NAME = 'student_task_manager';
    public const USERNAME = 'root';
    public const PASSWORD = '';
    public const CHARSET = 'utf8mb4';

    public static function getConnection(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            self::HOST,
            self::PORT,
            self::DB_NAME,
            self::CHARSET
        );

        return new PDO($dsn, self::USERNAME, self::PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
