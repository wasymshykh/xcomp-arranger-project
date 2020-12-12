
<?php include_once 'header.view.php'; ?>

<header class="header">
    <div class="header-inner">

        
        <div class="header-logo-row">
            <div class="header-logo">
                <img src="<?=URL?>/static/images/logo.svg" alt="Xcomp">
            </div>
            <div class="header-logo-slogan">
                <p><b>Admin</b> Panel</p>

            </div>
        </div>

        <div class="header-navigation">
            <a href="<?=URL?>/admin/keys.php"><i class="fas fa-key"></i> Keys</a>
            <a href="<?=URL?>/admin/orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
            <a href="<?=URL?>/admin/settings.php"><i class="fas fa-cogs"></i> Settings</a>
            <a href="<?=URL?>/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

    </div>
</header>

<section class="content">
    <div class="content-inner">
        
