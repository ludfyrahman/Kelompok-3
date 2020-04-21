<div class="inner-wrapper d-flex flex-column align-items-center justify-content-between p-4">
    <a href="index.html">
        <img src="<?= BASEASSET ?>/images/logo/logo-3.png" alt="">
    </a>
    <!-- ***** Forgot Area Start ***** -->
    <div class="forgot-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 mb-5 mb-md-0 mx-auto pt-4 pt-md-0">
                    <img src="<?= BASEASSET ?>/images/welcome/forgot-thumb.png" alt="">
                </div>
                <div class="col-12 col-md-6 col-lg-6 mb-5 mb-md-0">
                    <h2 class="text-primary">Lupa Password Kamu?</h2>
                    <p class="mt-3 mb-4">Masukkan email akun anda yang terdaftar di aplikasi kami. maka kami akan mengirimkan kode verifikasi ke email anda untuk mengubah password</p>
                    <form action="" method="POST">
                    <?php Response::part('alert'); ?>
                    <div class="input-group reset-password">
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email kamu">
                            <div class="input-group-append mt-3 mt-sm-0">
                                <button type="submit" class="btn btn-primary">Reset</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>