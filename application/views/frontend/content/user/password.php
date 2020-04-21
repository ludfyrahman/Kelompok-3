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
                    <h2 class="text-primary">Ubah Password</h2>
                    <p class="mt-3 mb-4">Ubah password kamu untuk masuk akun papikos</p>
                    <?php Response::part('alert'); ?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" placeholder="masukkan password baru kamu">
                        </div>
                        <div class="form-group">
                            <label for="">Ulangi Password Baru</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru kamu">
                        </div>
                        <div class="form-group">
                        <input type="submit" value="Ubah Password" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>