<?php
    use PayPal\Rest\ApiContext;
    use PayPal\Auth\OAuthTokenCredential;

    session_start();

    // Main project directory
    define('DIR', dirname(__DIR__).'/');

    // Website url without '/' at the end
    define('URL', "http://localhost/xcomp-arranger");

    
    // Either: development/production
    define('PROJECT_MODE', 'development'); 

    if (PROJECT_MODE !== 'development') {
        error_reporting(0);
    } else {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    // Database connection details
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'xcomp_db');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    
    // Timezone setting
    define('TIMEZONE', 'Asia/Karachi');
    date_default_timezone_set(TIMEZONE);
    
    // Auto load classes
    include DIR . 'config/auto_loader.php';
    include DIR . 'vendor/autoload.php';

    // Functions
    include DIR . 'includes/functions.php';

    
    // Get db handle
    $db = (new DB())->connect();

    $settings = get_settings();
    
    define('PAYPAL_CLIENT_ID', get_setting('paypal_client_id'));
    define('PAYPAL_CLIENT_SECRET', get_setting('paypal_client_secret'));
    define('PRODUCT_COST', get_setting('product_cost'));

    $apiContext = new ApiContext(new OAuthTokenCredential(PAYPAL_CLIENT_ID, PAYPAL_CLIENT_SECRET));

