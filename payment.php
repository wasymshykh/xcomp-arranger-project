<?php

use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;

require_once 'config/init.php';

$payer = new Payer();

$payer->setPaymentMethod('paypal');

$amount = new Amount();
$amount->setTotal(PRODUCT_COST);
$amount->setCurrency('USD');

$transaction = new Transaction();
$transaction->setAmount($amount);

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(URL."/success.php")->setCancelUrl(URL);

$payment = new Payment();
$payment->setIntent('sale')->setPayer($payer)->setTransactions(array($transaction))->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
    go($payment->getApprovalLink());
}
catch (PayPalConnectionException $ex) {
    echo "System error while connecting to paypal.";
}

