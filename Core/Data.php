<?php

function connectToDB(): PDO
{
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) {
        throw new Exception("Brak pliku .env w katalogu głównym aplikacji.");
    }

    $read_env = parse_ini_file($envPath);
    $host = $read_env['DB_HOST'] ?? '';
    $dbname = $read_env['DB_NAME'] ?? '';
    $username = $read_env['DB_USER'] ?? '';
    $password = $read_env['DB_PASS'] ?? '';

    if (!$host || !$dbname || !$username) {
        throw new Exception("Brak wymaganych danych połączenia w pliku .env.");
    }

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception("Błąd połączenia z bazą danych: " . $e->getMessage());
    }
}
