<?php

function connectToDB():PDO{
    $read_env = parse_ini_file('.env');
    $host = $read_env['DB_HOST'];
    $dbname = $read_env['DB_NAME'];
    $username = $read_env['DB_USER'];
    $password = $read_env['DB_PASS'];

    $dsn = "mysql:host=$host;dbname=$dbname";

    return new PDO($dsn, $username, $password);

}
