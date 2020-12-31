<?php if($message): ?>
    <div class="message message-<?=$message['type']?>">
        <?=$message['text']?>
    </div>
<?php endif; ?>

<table class="dt">
    <thead>
        <tr>
            <th>#</th>
            <th>Fingerprint</th>
            <th>Serial</th>
            <th>Key</th>
            <th>Generated On</th>
            <th>User IP</th>
            <th>Email</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($keys as $key): ?>
        <tr>
            <td><?=$key['key_id']?></td>
            <td><?=$key['key_fingerprint']?></td>
            <td><?=$key['key_serial']?></td>
            <td><?=$key['key_key']?></td>
            <td><?=normal_date($key['key_created_on'])?></td>
            <td><?=$key['key_created_ip']?></td>
            <td><?=$key['key_email']?></td>
            <td><?=key_status($key['key_status'])?></td>
            <td>
                <?php if($key['key_status'] === 'A'): ?>
                    <form action="" method="post"><input type="hidden" name="block" value="<?=$key['key_id']?>"><button type="submit" class="red-button">Block</button></form>
                <?php else: ?>
                    <form action="" method="post"><input type="hidden" name="unblock" value="<?=$key['key_id']?>"><button type="submit" class="green-button">Unblock</button></form>
                <?php endif; ?>
                <form action="" method="post"><input type="hidden" name="delete" value="<?=$key['key_id']?>"><button type="submit" class="red-button">Delete</button></form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
