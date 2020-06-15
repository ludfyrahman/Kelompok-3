<section class="section login-area h-100vh py-4">
    <div class="container h-100">
        <div class="row align-items-center justify-content-center h-100">
            <div class="col-12 col-sm-10 col-md-6 col-lg-6 mx-auto d-none d-md-block">
                <div class="login-slider owl-carousel">
                    <img src="<?= BASEASSET ?>/images/welcome/login-1.svg" alt="">
                    <img src="<?= BASEASSET ?>/images/welcome/login-2.svg" alt="">
                    <img src="<?= BASEASSET ?>/images/welcome/login-3.svg" alt="">
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-5">
                <!-- Appo Modal -->
                <div class="appo-modal py-4 p-lg-4">
                    <!-- Modal Content -->
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header p-0 border-0">
                            <ul class="nav nav-pills" id="pills-tab">
                                <li class="nav-item">
                                    <a class="nav-link active" id="login-tab" data-toggle="pill" href="#login">Masuk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="signup-tab" data-toggle="pill" href="#signup">Daftar</a>
                                </li>
                            </ul>
                            <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="tab-content" id="pills-tabContent">
                                <!-- Login Form -->
                                <div class="tab-pane fade show active" id="login">
                                    <form action="<?= BASEURL."pengguna/proses_login" ?>" method="post" class="login-form">
                                        <!-- Social Login -->
                                        <div class="social-login text-center">
                                            <h5 class="fw-4 mt-2 mb-3">Masuk dengan akun sosial media anda</h5>
                                            <!-- Social Icons -->
                                            <div class="social-icons d-flex justify-content-center">
                                                <!-- <a class="facebook" href="#">
                                                    <i class="fab fa-facebook-f"></i>
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                                <a class="twitter" href="#">
                                                    <i class="fab fa-twitter"></i>
                                                    <i class="fab fa-twitter"></i>
                                                </a> -->
                                                <!-- <a class="google-plus" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online&tipe=login' ?>">
                                                    <i class="fab fa-google-plus-g"></i>
                                                    <i class="fab fa-google-plus-g"></i>
                                                </a> -->
                                            </div>
                                        </div>
                                        <!-- Profile Login -->
                                        <div class="profile-login mb-2 p-4">
                                            <span class="bg-white p-2">or</span>
                                        </div>
                                        <?php Response_Helper::part('alert'); ?>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="<?= Input_Helper::postOrOr('email') ?>" placeholder=" Email" name="email" aria-label="Username" aria-describedby="basic-addon1" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2"><i class="fas fa-unlock-alt"></i></span>
                                            </div>
                                            <input type="password" class="form-control" placeholder="Password" name="password" aria-label="Password" aria-describedby="basic-addon2" required>
                                        </div>
                                        <div class="custom-control custom-checkbox d-flex my-4">
                                            <div class="remember">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                            </div>
                                            <div class="forgot-password ml-auto">
                                                <span><a href="<?= BASEURL."lupa_password" ?>">Lupa Password?</a></span>
                                            </div>
                                        </div>
                                        <!-- Login Button -->
                                        <button type="submit" class="btn btn-bordered d-block btn-block">Masuk</button>
                                        <p style="padding:12px;text-align:center"><a href="<?= BASEURL ?>">Kembali Ke Beranda</a></p>
                                    </form>
                                </div>
                                <!-- Signup Form -->
                                <div class="tab-pane fade" id="signup">
                                    <form action="<?= BASEURL."pengguna/proses_register" ?>" method="POST" class="login-form signup-form">
                                        <!-- Social Login -->
                                        <div class="social-login text-center">
                                            <h5 class="fw-4 mt-2 mb-3">Mendaftar untuk mengakses aplikasi kami</h5>
                                            <!-- Social Icons -->
                                            <div class="social-icons d-flex justify-content-center">
                                                <!-- <a class="facebook" href="#">
                                                    <i class="fab fa-facebook-f"></i>
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                                <a class="twitter" href="#">
                                                    <i class="fab fa-twitter"></i>
                                                    <i class="fab fa-twitter"></i>
                                                </a> -->
                                                <a class="google-plus" href="<?= 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online&tipe=register' ?>">
                                                    <i class="fab fa-google-plus-g"></i>
                                                    <i class="fab fa-google-plus-g"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Profile Login -->
                                        <div class="profile-login mb-2 p-4">
                                            <span class="bg-white p-2">or</span>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon3"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="nama" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon3" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon4"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?= Input_Helper::postOrOr('email') ?>" aria-label="Email" aria-describedby="basic-addon4" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon5"><i class="fas fa-unlock-alt"></i></span>
                                            </div>
                                            <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon5" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon5"><i class="fas fa-unlock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" name="password_confirmation" placeholder="Password Konfirmasi" aria-describedby="basic-addon5" required>
                                        </div>
                                        <!-- Signup Button -->
                                        <button class="btn btn-bordered btn-block" type="submit">Mendaftar</button>
                                        <p style="padding:12px;text-align:center"><a href="<?= BASEURL ?>">Kembali Ke Beranda</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>