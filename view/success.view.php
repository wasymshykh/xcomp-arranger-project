<header class="header">
    <div class="header-inner">

        <div class="header-logo-row" style="justify-content: center">
            <div class="header-logo">
                <img src="static/images/logo.svg" alt="Xcomp">
            </div>
            <div class="header-logo-slogan">
                <p><b>Integraded</b> High quality synth engine</p>
            </div>
        </div>

    </div>
</header>

<section class="payment-receipt">
    <div class="payment-receipt-inner">

        <div class="payment-receipt-box">
            <?php if($message): ?>
                <div class="message message-<?=$message['type']?>">
                    <strong>Important!</strong> <?=$message['text']?>
                </div>
            <?php endif; ?>

            <h3>Payment <span>Successful</span>!</h3>
            <p>Thank you for your payment.</p>
        </div>

    </div>
</section>
