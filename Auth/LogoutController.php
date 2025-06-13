<?php

class LogoutController
{

    public function logout()
    {
        $router = new Router();

        session_start();
        session_unset();
        session_destroy();
        header("Location:" . $router->getBasePath() . "/" );
        exit;
    }

}