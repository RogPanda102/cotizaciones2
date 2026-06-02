<?php

function old($key, $default = '')
{
    if (isset($_SESSION['old'][$key])) {
        return $_SESSION['old'][$key];
    }

    return $default ?? '';
}