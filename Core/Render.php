<?php

function renderSite($viewPath, $data = []) {
    if (!empty($data) && is_array($data)) {
        extract($data);
    }
//    extract($data); // Converts keys in $data to variables
    include __DIR__ . '/../Views/layout/header.php';
    include $viewPath;
    include __DIR__ . '/../Views/layout/footer.php';
}

function render($viewPath, $data = []) {
    extract($data); // Converts keys in $data to variables
    include $viewPath;
}
