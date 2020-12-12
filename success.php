<?php

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

require_once 'config/init.php';

$p = new Pay($db);

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

include_once DIR . '/view/layout/header.view.php';
include_once DIR . '/view/success.view.php';
include_once DIR . '/view/layout/footer.view.php';
