<?php

namespace FlashMsg;

class Msg
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set_flash($key, $message)
    {
        $_SESSION['flash'][$key] = $message;
    }

    public function get_flash($key)
    {
        if (!isset($_SESSION['flash'][$key])) return null;
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
}