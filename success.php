<?php

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once 'config/init.php';

$p = new Pay($db);
$s = new Serial($db);

$paymentId = $_GET['paymentId'];
$payment = Payment::get($paymentId, $apiContext);
$execution = new PaymentExecution();
$execution->setPayerId($_GET['PayerID']);

$result = $payment->execute($execution, $apiContext);

try {
    $result = $payment->execute($execution, $apiContext);
    try {
        $payment = Payment::get($paymentId, $apiContext);
    } catch (Exception $ex) {
        echo 'Unable to get payment details';
        exit(1);
    }
} catch (Exception $ex) {
    echo 'Error while processing';
    exit(1);
}


// Get the transaction data 
$id = $payment->id; 

if ($p->get_payment_by('payment_txn_id', $id)) {
    // if the payment is already present then redirect to website home.
    go(URL . '/');
}

$state = $payment->state; 
$payerFirstName = $payment->payer->payer_info->first_name; 
$payerLastName = $payment->payer->payer_info->last_name; 
$payerName = $payerFirstName.' '.$payerLastName; 
$payerEmail = $payment->payer->payer_info->email; 
$payerID = $payment->payer->payer_info->payer_id; 
$payerCountryCode = $payment->payer->payer_info->country_code; 
$paidAmount = $payment->transactions[0]->amount->details->subtotal; 
$currency = $payment->transactions[0]->amount->currency; 

$p->insert($id, $paidAmount, $currency, $payerID, $payerName, $payerEmail, $payerCountryCode, $state);

// generate serial
$unique_serial = $s->generate_unqiue_serial();

if ($unique_serial['status']) {
    
    $r = $s->insert($unique_serial['message'], $payerEmail);
    if ($r) {
        
        $mail = new PHPMailer(true);
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = get_setting('smtp_host');
        $mail->SMTPAuth = true;
        $mail->Username = get_setting('smtp_username');
        $mail->Password = get_setting('smtp_password');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = get_setting('smtp_port');
        $mail->setFrom(get_setting('mailer_email'), get_setting('mailer_name'));
        $mail->addAddress($payerEmail, $payerName);

        $re = $s->send_serial_to_email($mail, $unique_serial['message']);

        if ($re === true) {

            $message = ['type' => 'success', 'text' => "Code have been successfully sent to email."];

        } else {
            $message = ['type' => 'error', 'text' => "We couldn't mail you the serial code, contact support."];
        }

    } else {
        $message = ['type' => 'error', 'text' => "Transaction recorded but couldn't record the serial"];
    }

} else {
    $message = ['type' => 'error', 'text' => "Transaction recorded but couldn't generate the serial"];
}

include_once DIR . '/view/layout/header.view.php';
include_once DIR . '/view/success.view.php';
include_once DIR . '/view/layout/footer.view.php';
