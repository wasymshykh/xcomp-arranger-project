
<table class="dt">
    <thead>
        <tr>
            <th>#</th>
            <th>Transaction ID</th>
            <th>Gross</th>
            <th>Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Status</th>
            <th>Dated</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($payments as $payment): ?>
        <tr>
            <td><?=$payment['payment_id']?></td>
            <td><?=$payment['payment_txn_id']?></td>
            <td><?=$payment['payment_gross'].' '.$payment['payment_currency_code']?></td>
            <td><?=$payment['payment_payer_name']?></td>
            <td><?=$payment['payment_payer_email']?></td>
            <td><?=$payment['payment_payer_country']?></td>
            <td><?=$payment['payment_payer_status']?></td>
            <td><?=normal_date($payment['payment_created_on'])?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
