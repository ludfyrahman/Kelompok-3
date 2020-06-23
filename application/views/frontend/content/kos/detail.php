<!-- ***** Blog Area Start ***** -->
<section id="blog" class="section blog-area ptb_100">
    <div class="container">
        <div class="row">
            
            <div class="col-12 col-lg-12">
                <!-- Single Blog Details -->
                <article class="single-blog-details">
                    <!-- Blog Thumb -->
                    <!-- <?php Response_Helper::breadcrumb()?> -->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="blog-thumb">
                                <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php
                                        $no = 1;
                                    foreach($media as $m){
                                        ?>
                                        <div class="carousel-item <?= ($no == 1 ? 'active' : '')?>">
                                            <img src="<?= BASEASSET."images/upload/kos/".$m['link_media'] ?>" class="d-block w-100" alt="...">
                                        </div>
                                        <?php $no++;} ?>
                                    </div>
                                </div>
                            </div>
                            <div class="slider-image margin-18">
                                <?php
                                    $no = 1;
                                    // print_r($media);
                                    foreach($media as $m){
                                ?>
                                    <div class="image-slide">
                                        <img src="<?= BASEASSET."images/upload/kos/".$m['link_media'] ?>" class="" alt="...">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="blog-content appo-blog">
                                <!-- Meta Info -->
                                <!-- Blog Details -->
                                <div class="blog-details">
                                    <h3 class="color-primary float-right"><?=Response_Helper::price($data['harga'])?> / Bulan</h3>
                                    <h3 class="blog-title py-2 py-sm-3 inline"><?= $data['nama_kos'] ?></h3>
                                    <h5 class="margin-top-bottom-12">Tersedia <?= $data['jumlah_kamar']?> kamar</h5>
                                    <h5 class="margin-top-bottom-12">Type Kamar</h5>
                                    <div class="row">
                                        <?php 
                                        foreach ($dk as $d){?>
                                        <div class="col-md-2">
                                            <a href="<?= BASEURL."kos/detail/".Response_Helper::uri(4)."/".$d['id']?>"><button class="btn <?= $this->uri->segment(4) == $d['id'] ? 'btn-success' : 'btn-primary' ?> btn-xs"><?=$d['type']?></button></a>
                                        </div>
                                    <?php }?>
                                    </div>
                                    <div class="meta-info d-flex flex-wrap align-items-center py-2">
                                        <ul>
                                            <li class="d-inline-block p-2">Pemilik Kos <?= $data['nama'] ?></li>
                                            <li class="d-inline-block p-2">Diubah <?= Response_Helper::date($data['tanggal_diubah'], "d M Y, H:i") ?></li>
                                        </ul>
                                    </div>
                                    <div class="rating padding12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <?php 
                                                
                                                for ($i=0; $i < round($rate); $i++) { ?>
                                                <i class="fa fa-star text-warning" ></i>
                                                <?php }
                                                $cal = 5 - round($rate);
                                                for ($i=0; $i < $cal; $i++) {
                                                ?>
                                                <i class="fa fa-star "></i>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-2">
                                                <p><?= count($ulasan) ?> ulasan</p>
                                            </div>
                                            <div class="col-md-2    ">
                                                <?php
                                                if(isset($_SESSION['userid'])){
                                                ?>
                                                    <a href="#" id="favorit" kosid="<?= $data['id'] ?>"><i class="icofont-heart-alt"></i></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row margin-12">
                                        <div class="col-md-2 col-sm-2">
                                            <div class="row">
                                                
                                                <div class="col-md-6 text-center">
                                                    Dilihat
                                                    <p><?= $data['dilihat'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-2 col-sm-2">
                                            <div class="row">
                                                
                                                <div class="col-md-12 text-center">
                                                    Dipesan
                                                    <p>20</p>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-md-4 col-sm-4">
                                            <div class="row">
                                                
                                                <div class="col-md-12 text-center">
                                                    Jumlah Kamar
                                                    <p><?= $data['jumlah_kamar'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <div class="row">
                                                
                                                <div class="col-md-12 text-center">
                                                    Jenis Kos
                                                    <p><?= jenis_kelamin[$data['jenis']] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="<?= BASEURL."kos/pesan/".$data['id']."/".($this->uri->segment(4) == "" ? $dk[0]['id']: $this->uri->segment(4))?>"><button class="btn btn-success float-right">Pesan</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="informasi-tab" data-toggle="tab" href="#informasi" role="tab" aria-controls="informasi" aria-selected="true"><i class="fa fa-clipboard-list"></i>  Informasi Kos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ulasan-tab" data-toggle="tab" href="#ulasan" role="tab" aria-controls="ulasan" aria-selected="false"><i class="fa fa-swatchbook"></i> Ulasan</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="informasi" role="tabpanel" aria-labelledby="informasi-tab">
                                    <div class="container">
                                        <h4 class="margin-top-bottom-12">Deskripsi</h4>
                                        <p class="d-none d-sm-block text-justify"><?= $data['deskripsi'] ?></p>
                                        <h4 class="margin-top-bottom-12">Fasilitas</h4>
                                        <?php 
                                        foreach ($subfas as $sf) {
                                        ?>
                                        <h5 class="margin-top-bottom-12" style="margin-left:12px"><?= $sf['nama'] ?></h5>
                                        <div class="row">
                                        <?php 
                                        foreach ($sf['sub'] as $sub) {
                                            ?>
                                            <div class="col-md-2" style="margin-left:24px">
                                                <i class="fa fa-book"></i> <?= $sub['nama'] ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                        <!-- <h4 class="margin-top-bottom-12">Lokasi Kos</h4> -->
                                        <div style="clear:both"></div>
                                        <div id="map">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ulasan" role="tabpanel" aria-labelledby="ulasan-tab">
                                    <?php
                                    if(count($ulasan) < 1){
                                        echo "<div class='text-center'>
                                            <img src='".BASEASSET."images/welcome/404.gif' style='width:400px'>
                                            <h3>Data Ulasan Kosong</h3>
                                        </div>";
                                    }
                                    foreach ($ulasan as $u) {
                                    ?>
                                    <div class="single-blog wow fadeIn res-margin" data-wow-duration="2s">
                                        <!-- Blog Content -->
                                        <div class="blog-content p-4">
                                            <!-- Meta Info -->
                                            
                                            <ul class="meta-info d-flex justify-content-between">
                                                <li>Dari <b><?= $u['nama'] ?></b>  
                                                <?php 
                                                for ($i=1; $i <= $u['rating'] ; $i++) { 
                                                ?>
                                                    <i class="fa fa-star"></i>
                                                <?php }?>
                                            </li>
                                                <li><?= Response_Helper::date($u['tanggal_ditambahkan']) ?></li>
                                            </ul>
                                            <div class="container">
                                            <p><?= $u['ulasan'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Blog Content -->
                </article>
            </div>
        </div>
    </div>
</section>
<!-- ***** Blog Area End ***** -->