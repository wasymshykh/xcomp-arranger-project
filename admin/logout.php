<?php

require_once '../config/init.php';

// checking if user is logged in
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    go(URL . '/admin');
}

session_destroy();
session_unset();

go(URL . '/admin');
