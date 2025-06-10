<?php
class LogoutController
{

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /ticketpro_app/");
        exit;
    }

}