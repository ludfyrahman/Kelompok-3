<!-- ***** Blog Area Start ***** -->
<section id="blog" class="section blog-area ptb_100">
    <div class="container">
        <div class="row">
            
            <div class="col-12 col-lg-12">
                <!-- Single Blog Details -->
                <article class="single-blog-details">
                    <!-- Blog Thumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Kos Jomblo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pemesanan Kos Jomblo</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="margin-top-bottom-12"><?= Account_Helper::Get('nama') ?></h3>
                            <p class="margin-top-bottom-12"><?= Account_Helper::Get('no_hp') ?></p>
                        </div>
                        <div class="col-md-5">
                            <div class="blog-thumb">
                                <img src="<?= BASEASSET."images/upload/kos/".$media['link_media'] ?>" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="blog-content appo-blog">
                                <!-- Meta Info -->
                                <!-- Blog Details -->
                                <div class="blog-details">
                                    <h3 class="float-right"><?=Response_Helper::price($data['harga'])?> / Bulan</h3>
                                    <h3 class="blog-title py-2 py-sm-3 inline"><?= $data['nama_kos'] ?></h3>
                                    <h5 class="margin-top-bottom-12">Tersedia <?= $data['jumlah_kamar']?> kamar</h5>
                                    <div class="row">
                                        <div class="col-md-8">
                                            Pembayaran DP 
                                            <!-- <span>*dp yang harus dibayarkan</span> -->
                                        </div>
                                        <div class="col-md-3">
                                            <h3 class="float-right color-primary "><?= Response_Helper::price(25/100 * $data['harga']) ?></h3>
                                        </div>
                                    </div>
                                    <div class="meta-info d-flex flex-wrap align-items-center py-2">
                                        <ul>
                                            <li class="d-inline-block p-2">Pemilik Kos <b><?= $data['nama'] ?></b></li>
                                            <li class="d-inline-block p-2">Diubah <?= Response_Helper::date($data['tanggal_diubah'], "d M Y, H:i") ?></li>
                                            <!-- <li class="d-inline-block p-2"><a href="#">2 Comments</a></li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="margin-top-bottom-12">Pembayaran Melalui Rekening</h3>
                                    <p class="margin-top-bottom-12"><?=Account_Helper::Get('nama_bank')." ".Account_Helper::Get('no_rekening')."(".Account_Helper::Get('nama_rekening').")"?></p>
                                </div>
                                <div class="col-md-6">
                                    <p style="text-align:right">Batas maksimal pembayaran dp 1 x 24 jam</p>
                                    <a href="<?= BASEURL."kos/pesanAction/".$data['id']."/".Response_Helper::uri(5) ?>" class='pesan'><button class="btn btn-success float-right" >Pesan Kos</button></a>
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