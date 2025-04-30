<?php

function render($viewPath, $data = []) {
    include __DIR__ . '/../Views/layout/header.php';
    extract($data); // Converts keys in $data to variables
    include $viewPath;
    include __DIR__ . '/../Views/layout/footer.php';
}
