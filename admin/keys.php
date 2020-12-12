<?php

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

$k = new Key($db);

if (isset($_POST) && !empty($_POST)) {

    // post request for block
    if (isset($_POST['block']) && is_numeric($_POST['block']) && !empty($_POST['block'])) {
        if ($k->update_key_status('B', normal_text($_POST['block']))) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Status changed successfully.'];
            go(URL . '/admin/keys.php');
        }
        $message = ['type' => 'error', 'text' => 'Unable to update the status'];
    }
    
    // post request for unblock
    if (isset($_POST['unblock']) && is_numeric($_POST['unblock']) && !empty($_POST['unblock'])) {
        if ($k->update_key_status('A', normal_text($_POST['unblock']))) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Status changed successfully.'];
            go(URL . '/admin/keys.php');
        }
        $message = ['type' => 'error', 'text' => 'Unable to update the status'];
    }

    // post request for delete
    if (isset($_POST['delete']) && is_numeric($_POST['delete']) && !empty($_POST['delete'])) {
        if ($k->update_key_deleted(normal_text($_POST['delete']))) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Key is successfully deleted.'];
            go(URL . '/admin/keys.php');
        }
        $message = ['type' => 'error', 'text' => 'Unable to update the status'];
    }

}

$keys = $k->get_keys();

$datatable = true;

include_once DIR . 'view/layout/admin_header.view.php';
include_once DIR . 'view/keys.view.php';
include_once DIR . 'view/layout/admin_footer.view.php';

