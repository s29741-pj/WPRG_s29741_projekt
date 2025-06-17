<?php

function renderSite($viewPath, $data = [])
{
    extract($data); // Zamienia klucze tablicy $data na zmienne
    include __DIR__ . '/../Views/layout/header.php';
    include $viewPath;
    include __DIR__ . '/../Views/layout/footer.php';
}

function render($viewPath, $data = [])
{
    extract($data); // Zamienia klucze tablicy $data na zmienne
    include $viewPath;
}
