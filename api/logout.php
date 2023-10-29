<?php
    setcookie('user', '', time() - 3600 * 6, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);