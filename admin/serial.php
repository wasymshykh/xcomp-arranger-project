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

$s = new Serial($db);

var_dump($s->generate_unqiue_serial());

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['delete']) && !empty(normal_text($_POST['delete'])) && is_numeric($_POST['delete'])) {

        $serial_id = normal_text($_POST['delete']);

        $r = $s->get_serial_by('serial_id', $serial_id);

        if ($r['message']) {

            if ($s->update_serial_status('D', $serial_id)) {

                $_SESSION['message'] = ['type' => 'success', 'text' => "Serial #$serial_id is successfully deleted."];
                go(URL . '/admin/serial.php');

            } else {
                $message = ['type' => 'error', 'text' => 'Unable to delete the serial.'];
            }

        } else {
            $message = ['type'=>'error', 'text' => 'Serial not found.'];
        }
    }

    if (isset($_POST['add-serial'])) {
        // create serial form submission

        $code = normal_text($_POST['code']);
        $email = !empty(normal_text($_POST['email'])) ? normal_text($_POST['email']) : NULL;
        
        if (!empty($code)) {

            // checking if code already exists
            $r = $s->get_serial_by('serial_code', $code);

            if (!$r['message']) {

                $r = $s->insert($code, $email);

                if ($r['status']) {

                    $_SESSION['message'] = ['type' => 'success', 'text' => $r['message']];
                    go(URL . '/admin/serial.php');

                } else {
                    $message = ['type' => 'error', 'text' => 'Unable to insert the serial code'];
                }

            } else {
                $message = ['type' => 'error', 'text' => 'Serial code already exists in the database.'];
            }
        } else {
            $message = ['type' => 'error', 'text' => 'Serial code cannot be empty.'];
        }

    }

}

$serials = $s->get_serials();

$datatable = true;


include_once DIR . 'view/layout/admin_header.view.php';
include_once DIR . 'view/serial.view.php';
include_once DIR . 'view/layout/admin_footer.view.php';
