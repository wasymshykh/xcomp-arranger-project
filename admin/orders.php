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

$p = new Pay($db);

$payments = $p->get_payments();

$datatable = true;

include_once DIR . 'view/layout/admin_header.view.php';
include_once DIR . 'view/orders.view.php';
include_once DIR . 'view/layout/admin_footer.view.php';


