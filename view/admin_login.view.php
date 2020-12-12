<section class="login-box">
    <form action="" method="POST" class="login-box-inner">
        
        <div class="header-logo-row">
            <div class="header-logo">
                <img src="<?=URL?>/static/images/logo.svg" alt="Xcomp">
            </div>
            <div class="header-logo-slogan">
                <p><b>Admin</b> Panel</p>

            </div>
        </div>

        <?php if($message): ?>
            <div class="message message-<?=$message['type']?>">
                <?=$message['text']?>
            </div>
        <?php endif; ?>

        <div class="login-input-row">
            <label for="username"><i class="fas fa-user"></i> Username</label>
            <input type="text" name="username" id="username" value="<?=$_POST['username'] ?? ''?>">
        </div>
        <div class="login-input-row">
            <label for="password"><i class="fas fa-key"></i> Password</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="login-input-button">
            <button type="submit">Login <i class="fas fa-arrow-right"></i></button>
        </div>

    </form>
</section>
