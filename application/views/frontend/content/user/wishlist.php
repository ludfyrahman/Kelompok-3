<!-- ***** Blog Area Start ***** -->
<section id="blog" class="section blog-area ptb_100">
    <div class="container">
        <div class="row">
            <?php
            Response::part('sidebar_profile');
            ?>
            <div class="col-12 col-lg-9">
                <article class="single-blog-details">
                    <h2 class="margin-top-bottom-12">Daftar Favorit</h2>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cari" placeholder="pencarian">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="search" class="btn btn-success"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                    <?php 
                    foreach ($data as $k) {
                        // $link = BASEURL."kos/detail/".
                    ?>
                    <div class="col-12 col-md-6 col-lg-4"  style="margin-top:20px;">
                        <!-- Single Blog -->
                        <div class="single-blog wow fadeIn res-margin" data-wow-duration="2s">
                            <!-- Blog Thumb -->
                            <div class="blog-thumb">
                                <img style="height:200px" src="<?=BASEASSET?>/images/upload/kos/<?= $k['link_media'] ?>" alt="">
                            </div>
                            <!-- Blog Content -->
                            <div class="blog-content p-4">
                                <!-- Blog Title -->
                                <h3 class="blog-title my-3"><a href="#"><?= substr($k['nama'], 0,15)."..." ?></a></h3>
                                <p><?= App::price($k['harga']) ?></p>
                                <a href="<?= BASEURL."kos/detail/".$k['id'] ?>" class="blog-btn mt-3">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<!-- ***** Blog Area End ***** -->