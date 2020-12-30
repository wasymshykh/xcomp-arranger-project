<?php if($message): ?>
    <div class="message message-<?=$message['type']?>">
        <?=$message['text']?>
    </div>
<?php endif; ?>

<div class="serial">

    <div class="serial-left">
        <h1 class="serial-heading">Add a new serial</h1>
        
        <form method="POST" action="" class="setting-box">
            <div class="serial-input-row">
                <label for="code">Serial Number</label>
                <input type="number" name="code" id="code" value="<?=$_POST['code'] ?? ''?>" required>
            </div>
            <div class="serial-input-row">
                <label for="email">Email (optional)</label>
                <input type="email" name="email" id="email" value="<?=$_POST['email'] ?? ''?>">
            </div>
            <div class="serial-input-button">
                <input type="hidden" name="add-serial">
                <button type="submit"><i class="fas fa-plus"></i> Add</button>
            </div>
        </form>
    </div>


    <div class="serial-right">

        <table class="dt">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Serial Code</th>
                    <th>Email</th>
                    <th>Created On</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($serials as $serial): ?>
                <tr>
                    <td><?=$serial['serial_id']?></td>
                    <td><?=$serial['serial_code']?></td>
                    <td><?=$serial['serial_email'] ?? '<i>no email</i>'?></td>
                    <td><?=normal_date($serial['serial_created_on'])?></td>
                    <td><?=serial_status($serial['serial_status'])?></td>
                    <td>
                        <form action="" method="post"><input type="hidden" name="delete" value="<?=$serial['serial_id']?>"><button type="submit" class="red-button">Delete</button></form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>
