<?php

function old($key, $default = null)
{
    if (isset($_SESSION['old'][$key])) {
        return $_SESSION['old'][$key];
    }

    return $default;
}