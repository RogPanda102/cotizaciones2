<?php

    function session($key = null)
    {
        if ($key === null) {
            return $_SESSION;
        }

        return $_SESSION[$key] ?? null;
    }

    function session_put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    function session_forget($key)
    {
        unset($_SESSION[$key]);
}