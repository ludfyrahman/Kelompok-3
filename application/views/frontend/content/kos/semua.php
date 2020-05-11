<section id="blog" class="section blog-area ptb_100">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-3">
                <aside class="sidebar">
                    <!-- Single Widget -->
                    <div class="single-widget">
                        <!-- Search Widget -->
                        <div class="widget-content search-widget">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Nama Kos</label>
                                    <input type="text" placeholder="cari" name="cari" value="<?= Input_Helper::postOrOr('cari') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Kategori Kos</label>
                                    <select name="kategori" id="" class="form-control">
                                        <option value="">Semua</option>
                                    <?php
                                    $tp = Input_Helper::postOrOr('tipe');
                                    foreach ($kategori as $k) {
                                    ?>
                                        <option value="<?= $k['id'] ?>" <?= ($tp == $k['id'] ? 'selected' : '') ?>><?= $k['nama'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tipe Kos</label>
                                    <?php
                                    $tp = Input_Helper::postOrOr('tipe');
                                    ?>
                                    <select name="tipe" id="" class="form-control">
                                        <option value="">Semua</option>
                                        <option value="1" <?= $tp == "1" ? 'selected' : '' ?>>Laki-Laki</option>
                                        <option value="2" <?= $tp == "2" ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Urutkan</label>
                                    <select name="urut" id="" class="form-control">
                                        <option value="">Semua</option>
                                        <option value="1" <?= (Input_Helper::postOrOr('urut') == 1 ? "selected" : "") ?>>Terbaru</option>
                                        <option value="2" <?= (Input_Helper::postOrOr('urut') == 2 ? "selected" : "") ?>>Termurah</option>
                                        <option value="3" <?= (Input_Helper::postOrOr('urut') == 3 ? "selected" : "") ?>>Tertinggi</option>
                                    </select>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="">Jarak (m)</label>
                                    <input type="text" placeholder="jarak" name="jarak" value="<?= Input_Helper::postOrOr('jarak') ?>">
                                </div> -->
                                <!-- <div class="form-group">
                                    <label for="">Fasilitas</label>
                                    <?php
                                    foreach($fasilitas as $f){
                                    ?>
                                    <input type="checkbox" ><?= $f[''] ?>
                                    <?php
                                    }
                                    ?>
                                </div> -->
                                <div class="form-group">
                                    <label for="">Rentang Harga</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="text" placeholder="harga awal"  name="harga_awal" class="form-control" value="<?= Input_Helper::postOrOr('harga_awal', '100000') ?>">
                                        </div>
                                        <div class="col-md-1">
                                            -
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" placeholder="harga tertinggi" name="harga_tertinggi" value="<?= Input_Helper::postOrOr('harga_tertinggi') ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-success btn-block">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-12 col-lg-9">
                <div class="row">
                <?php 
                 if(count($data) < 1){
                    echo "<div class='col-md-12 text-center'>
                        <img src='".BASEASSET."images/welcome/404.gif' class='img-fluid'>
                        <h3>Data Kosong</h3>
                    </div>";
                }
                foreach ($data as $k) {
                    $nama = explode(" ", $k['nama_pemilik']);
                ?>
                <div class="col-12 col-md-6 col-lg-4"  style="margin-top:20px;">
                    <!-- Single Blog -->
                    <div class="single-blog wow fadeIn res-margin" data-wow-duration="2s">
                        <!-- Blog Thumb -->
                        <div class="blog-thumb">
                            <img style="height:200px" src="<?=BASEASSET?>/images/upload/kos/<?= $k['link_media'] ?>" alt="">
                        </div>
                        <!-- Blog Content -->
                        <div class="blog-content p-4" >
                            <!-- Meta Info -->
                            <ul class="meta-info d-flex justify-content-between" style="min-height:85px">
                                <li>By <a href="<?= BASEURL."kos/detail/".$k['id'] ?>"><?= $nama[0] ?></a></li>
                                <li><a href="<?= BASEURL."kos/detail/".$k['id'] ?>"><?= Response_Helper::Date($k['tanggal_ditambahkan'], 'd M Y') ?></a></li>
                            </ul>
                            <!-- Blog Title -->
                            <h3 class="blog-title my-3"><a href="#"><?= substr($k['nama'], 0,15)."..." ?></a></h3>
                            <span class="badge badge-secondary"><?= $k['kategori'] ?></span></h3>
                            <p><?= substr($k['deskripsi'], 0, 30)."..." ?></p>
                            <p><?= Response_Helper::price($k['harga']) ?></p>
                            <a href="<?= BASEURL."kos/detail/".$k['id'] ?>" class="blog-btn mt-3">Selengkapnya 
                            <!-- <?= $k['distance'] ?> -->
                            </a>
                            <?php
                            if(isset($_SESSION['userid'])){
                            ?>
                                <a href="#" id="favorit" kosid="<?= $k['id'] ?>" class="blog-btn mt-3 float-right"><i class="icofont-heart-alt"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Blog Area End ***** -->