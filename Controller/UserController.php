<?php
require_once __DIR__ . '/../Core/View.php';



class UserController
{
    public function login() {
        $viewPath =  __DIR__ . '/../Views/login/login_page.php';
        renderSite($viewPath);
    }

}