<?php

use PayPal\Api\Payment;

require_once '../config/init.php';

// checking if user is logged in
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    go(URL . '/admin');
}

$message = false;
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}


if (isset($_POST) && !empty($_POST)) {

    // website settings save
    if (isset($_POST['website-settings'])) {

        $title = normal_text($_POST['title']);
        $cost = normal_text($_POST['cost']);

        $code = 0;
        if ($title !== get_setting('website_title')) {
            if (!update_setting('website_title', $title)) {
                $code = -1;
            }
        }
        if ($cost !== get_setting('product_cost')) {
            if (!update_setting('product_cost', $cost)) {
                $code = -1;
            }
        }

        if ($code === 0) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Website settings are saved.'];
            go(URL . '/admin/settings.php');
        } else {
            $message = ['type' => 'error', 'text' => 'Unable to save the settings.'];
        }

    }

    
    // paypal settings save
    if (isset($_POST['paypal-settings'])) {

        $id = normal_text($_POST['pp-id']);
        $secret = normal_text($_POST['pp-secret']);

        $code = 0;
        if ($id !== get_setting('paypal_client_id')) {
            if (!update_setting('paypal_client_id', $id)) {
                $code = -1;
            }
        }
        if ($secret !== get_setting('paypal_client_secret')) {
            if (!update_setting('paypal_client_secret', $secret)) {
                $code = -1;
            }
        }
        
        if ($code === 0) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Paypal settings are saved. Make sure to check it buy going to purchase page.'];
            go(URL . '/admin/settings.php');
        } else {
            $message = ['type' => 'error', 'text' => 'Unable to save the settings.'];
        }

    }

    
    // security settings save
    if (isset($_POST['security-settings'])) {

        $username = normal_text($_POST['username']);
        $password = normal_text($_POST['password']);

        $code = 0;
        if ($id !== get_setting('admin_username')) {
            if (!update_setting('admin_username', $id)) {
                $code = -1;
            }
        }
        if ($password !== get_setting('admin_password')) {
            if (!update_setting('admin_password', $password)) {
                $code = -1;
            }
        }
        
        if ($code === 0) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Security settings are saved.'];
            go(URL . '/admin/settings.php');
        } else {
            $message = ['type' => 'error', 'text' => 'Unable to save the settings.'];
        }

    }


}


include_once DIR . 'view/layout/admin_header.view.php';
include_once DIR . 'view/settings.view.php';
include_once DIR . 'view/layout/admin_footer.view.php';


