<div class="col-12 col-lg-3">
    <aside class="sidebar">
        
        <div class="single-widget">
            <!-- Category Widget -->
            <div class="accordions widget catagory-widget" id="cat-accordion">
                <div class="single-accordion blog-accordion">
                    <h5>
                        <a role="button" class="collapse show text-uppercase d-block p-3" data-toggle="collapse" href="#profil">Profil Saya
                        </a>
                    </h5>
                    <!-- Category Widget Content -->
                    <div id="profil" class="accordion-content widget-content collapse show" data-parent="#cat-accordion">
                        <!-- Category Widget Items -->
                        <ul class="widget-items">
                            <li><a href="<?= BASEURL."pengguna/profil" ?>" class="d-flex p-3"><span>Pengaturan</span></a></li>
                            <li><a href="<?= BASEURL."pengguna/wishlist" ?>" class="d-flex p-3"><span>Disukai</span></a></li>
                        </ul>
                    </div>
                    <h5>
                        <a role="button" class="collapse show text-uppercase d-block p-3" data-toggle="collapse" href="#transaksi">Transaksi</a>
                    </h5>
                    <!-- Category Widget Content -->
                    <div id="transaksi" class="accordion-content widget-content collapse show" data-parent="#cat-accordion">
                        <!-- Category Widget Items -->
                        <ul class="widget-items">
                            <li><a href="<?= BASEURL."transaksi" ?>" class="d-flex p-3"><span>Daftar Transaksi</span></a></li>
                            <!-- <li><a href="<?= BASEURL."transaksi" ?>" class="d-flex p-3"><span>Menunggu Pembayaran</span></a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>