<?php

require_once '../config/init.php';

if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
    go(URL . '/admin/keys.php');
}

$message = false;

if(isset($_POST) && !empty($_POST)) {

    // if the username field is sent and not empty
    if (isset($_POST['username']) && is_string($_POST['username']) && !empty($_POST['username'])) {

        // if the password field is sent and not empty
        if (isset($_POST['password']) && is_string($_POST['password']) && !empty($_POST['password'])) {

            // check if password and username is valid

            $username = normal_text($_POST['username']);
            $password = normal_text($_POST['password']);

            if ($username === get_setting('admin_username') && $password === get_setting('admin_password')) {

                $_SESSION['auth'] = true;
                go(URL . '/admin/keys.php');

            } else {
                $message = ['type' => 'error', 'text' => 'Invalid credentials!'];
            }
        } else {
            $message = ['type' => 'error', 'text' => 'Password cannot be empty!'];
        }
    } else {
        $message = ['type' => 'error', 'text' => 'Username cannot be empty!'];
    }

}

include_once DIR . 'view/layout/header.view.php';
include_once DIR . 'view/admin_login.view.php';
include_once DIR . 'view/layout/footer.view.php';

