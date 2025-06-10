<?php

namespace FlashMsg;

class msg
{

    private static ?msg $instance = null;


    public static function getInstance(): msg {
        if (self::$instance === null) {
            self::$instance = new msg();
        }
        return self::$instance;
    }

    function set_flash($key, $message) {
        $_SESSION['flash'][$key] = $message;
    }

    function get_flash($key) {
        if (!isset($_SESSION['flash'][$key])) return null;
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }

}