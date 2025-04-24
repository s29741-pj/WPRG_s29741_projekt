<?php

function render($viewPath, $data = []) {
    extract($data); // Converts keys in $data to variables
    include $viewPath;
}
