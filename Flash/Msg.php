<?php

namespace FlashMsg;

class Msg
{

    function set_flash($key, $message)
    {
        $_SESSION['flash'][$key] = $message;
    }

    function get_flash($key)
    {
        if (!isset($_SESSION['flash'][$key])) return null;
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }

}