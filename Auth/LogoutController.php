<?php
class LogoutController
{

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?route=login_page");
        exit;
    }

}