<div class="sidebar">
    <div class="user-profile">
        <div class="display-avatar animated-avatar">
        <img class="profile-img img-lg rounded-circle" src="<?= BASEASSET ?>/images/upload/profil/<?= Account_Helper::get("profil") ?>" alt="profile image">
        </div>
        <div class="info-wrapper">
        <p class="user-name"><?= Account_Helper::Get("nama") ?></p>
        <h6 class="display-income"><?= level[Account_Helper::Get("level")] ?></h6>
        </div>
    </div>
    <ul class="navigation-menu">
        <li class="nav-category-divider">MAIN</li>
        <li>
            <a href="<?= BASEADM."dashboard" ?>">
                <span class="link-title">Dashboard</span>
                <i class="mdi mdi-gauge link-icon"></i>
            </a>
        </li>
        <li>
            <a href="<?= BASEADM."kos" ?>">
                <span class="link-title">Kos</span>
                <i class="mdi mdi-home link-icon"></i>
            </a>
        </li>
        <?php
        if(Account_Helper::Get('level') == 1) {
        ?>
        <li>
            <a href="<?= BASEADM."pengguna" ?>">
                <span class="link-title">Pengguna</span>
                <i class="mdi mdi-account link-icon"></i>
            </a>
        </li>
        <li>
            <a href="<?= BASEADM."kategori" ?>">
                <span class="link-title">Kategori</span>
                <i class="mdi mdi-format-list-bulleted link-icon"></i>
            </a>
        </li>
        <li>
            <a href="#fasilitas" data-toggle="collapse" aria-expanded="false">
                <span class="link-title">Fasilitas</span>
                <i class="mdi mdi-flask link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="fasilitas">
                <li>
                    <a href="<?= BASEADM."fasilitas" ?>">Fasilitas</a>
                </li>
                <li>
                    <a href="<?= BASEADM."sub_fasilitas" ?>">Sub Fasilitas</a>
                </li>
                <!-- <li>
                    <a href="pages/sample-pages/error_2.html" target="_blank">Sub Fasilitas</a>
                </li> -->
            </ul>
        </li>
        <?php } ?> 
        <li class="nav-category-divider">Transaksi</li>
        <li>
            <a href="<?= BASEADM."pemesanan" ?>">
                <span class="link-title">Pemesanan</span>
                <i class="mdi mdi-asterisk link-icon"></i>
            </a>
        </li>
        <li>
            <a href="<?= BASEADM."pembayaran" ?>">
                <span class="link-title">Pembayaran</span>
                <i class="mdi mdi-paypal link-icon"></i>
            </a>
        </li>
        <?php
        if(Account_Helper::Get('level') == 1) {
        ?>
        <li>
            <a href="<?= BASEADM."report" ?>">
                <span class="link-title">Laporan</span>
                <i class="mdi mdi-format-list-checks link-icon"></i>
            </a>
        </li>
        <li class="nav-category-divider">Pengaturan</li>
        <!-- <li>
            <a href="<?= BASEADM."setting" ?>">
                <span class="link-title">Pengaturan</span>
                <i class="mdi mdi-settings link-icon"></i>
            </a>
        </li> -->
        <li>
            <a href="<?= base_url()."pengguna/profil" ?>">
                <span class="link-title">Profil</span>
                <i class="mdi mdi-account link-icon"></i>
            </a>
        </li>
        <?php } ?>
    </ul>
    <!-- <div class="sidebar-upgrade-banner">
        <p class="text-gray">Upgrade to <b class="text-primary">PRO</b> for more exciting features</p>
        <a class="btn upgrade-btn" target="_blank" href="http://www.uxcandy.co/product/label-pro-admin-template/">Upgrade to PRO</a>
    </div> -->
</div>