<!-- ***** Welcome Area Start ***** -->
<section id="home" class="section welcome-area d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <!-- Welcome Intro Start -->
            <div class="col-12 col-md-7 col-lg-6">
                <div class="welcome-intro">
                    <h1>Papikos</h1>
                    <h3 class="fw-3 mt-2 mt-sm-3">Mau cari kos?</h3>
                    <p class="my-3">Sekarang gak perlu repot lagi, dapatkan infonya di papi kos
Kos murah, nyaman, berkualitas dan strategis</p>
                    <div class="button-group">
                    <?php
                    if(isset($_SESSION['userlevel'])){
                    ?>
                        <a href="<?= BASEURL ?>kos/semua" class="btn btn-bordered"><span>Cari Kos</span></a>
                    <?php }else{?>
                        <a href="<?= BASEURL."pengguna/login"?>" class="btn btn-bordered"><span>Bergabung</span></a>
                        <a href="<?= BASEURL."pengguna/login"?>" class="btn btn-bordered d-none d-sm-inline-block">Masuk</a>
                    <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5 col-lg-6">
                <!-- Welcome Thumb -->
                <div class="welcome-thumb text-center" data-aos="fade-left" data-aos-delay="500" data-aos-duration="1000">
                    <img src="<?=BASEASSET?>/images/welcome-mockup-2.png" alt="">
                </div>
                <!-- Video Icon -->
                <div class="video-icon d-none d-lg-block">
                    <a class="play-btn" data-fancybox href="https://www.youtube.com/watch?v=Mft-c4N9J-g">
                        <i class="icofont-ui-play"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Welcome Area End ***** -->