<?php if($message): ?>
    <div class="message message-<?=$message['type']?>">
        <?=$message['text']?>
    </div>
<?php endif; ?>

<div class="setting">
    <h1 class="setting-heading">Website Settings</h1>
    
    <form method="POST" action="" class="setting-box">
        <div class="setting-input-row">
            <label for="title">Website Title</label>
            <input type="text" name="title" id="title" value="<?=$_POST['title'] ?? get_setting('website_title')?>">
        </div>
        <div class="setting-input-row">
            <label for="cost">Product Cost</label>
            <input type="number" name="cost" id="cost" step="any" value="<?=$_POST['cost'] ?? get_setting('product_cost')?>">
        </div>
        <div class="setting-input-button">
            <input type="hidden" name="website-settings">
            <button type="submit"><i class="fas fa-save"></i> Save</button>
        </div>
    </form>
</div>

<div class="setting">
    <h1 class="setting-heading">Paypal Settings</h1>
    
    <form method="POST" action="" class="setting-box">
        <div class="setting-input-row">
            <label for="pp-id">Paypal Client ID</label>
            <input type="text" name="pp-id" id="pp-id" value="<?=$_POST['pp-id'] ?? get_setting('paypal_client_id') ?>">
        </div>
        <div class="setting-input-row">
            <label for="pp-secret">Paypal Client Secret</label>
            <input type="text" name="pp-secret" id="pp-secret" value="<?=$_POST['pp-secret'] ?? get_setting('paypal_client_secret') ?>">
        </div>
        <div class="setting-input-button">
            <input type="hidden" name="paypal-settings">
            <button type="submit"><i class="fas fa-save"></i> Save</button>
        </div>
    </form>
</div>

<div class="setting">
    <h1 class="setting-heading">Security Settings</h1>
    
    <form method="POST" action="" class="setting-box">
        <div class="setting-input-row">
            <label for="username">New Admin Username</label>
            <input type="text" name="username" id="username" value="<?=$_POST['username'] ?? get_setting('admin_username') ?>">
        </div>
        <div class="setting-input-row">
            <label for="password">New Admin Password</label>
            <input type="text" name="password" id="password" value="<?=$_POST['password'] ?? get_setting('admin_password') ?>">
        </div>
        <div class="setting-input-button">
            <input type="hidden" name="security-settings">
            <button type="submit"><i class="fas fa-save"></i> Save</button>
        </div>
    </form>
</div>


