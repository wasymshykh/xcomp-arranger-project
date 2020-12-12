
<?php

require_once '../config/init.php';

// checking if user is logged in
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    go(URL . '/admin/keys.php');
}

include_once DIR . 'view/layout/header.view.php';
include_once DIR . 'view/keys.view.php';
include_once DIR . 'view/layout/footer.view.php';

