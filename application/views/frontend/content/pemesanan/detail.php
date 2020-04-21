<!-- ***** Blog Area Start ***** -->
<section id="blog" class="section blog-area ptb_100">
    <div class="container">
        <div class="row">
            
            <div class="col-12 col-lg-12">
                <!-- Single Blog Details -->
                <article class="single-blog-details">
                    <!-- Blog Thumb -->
                    <!-- <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Kos Jomblo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pemesanan Kos Jomblo</li>
                        </ol>
                    </nav> -->
                    <h2 class="margin-top-bottom-12">Detail Pesanan</h2>
                    <div class="row">
                        <div class="col-md-12 margin-top-bottom-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="margin-top-bottom-12">Nomor Invoice</p>
                                    <p class="margin-top-bottom-12  font-weight-bold"><a class="color-primary" target="_blank" href="<?= BASEURL."invoice/$data[id]" ?>"><?= invoice_code."".$data['id'] ?></a></p>
                                    <p class="margin-top-bottom-12">Nama Pemesan Kos</p>
                                    <p class="margin-top-bottom-12 font-weight-bold"><?= $data['nama_pemilik'] ?></p>    
                                </div>
                                <div class="col-md-6">
                                    <p class="margin-top-bottom-12">Tanggal Pemesanan</p>
                                    <p class="margin-top-bottom-12 font-weight-bold"><?= App::Date($data['tanggal_pemesanan'], 'd M Y H:i:s') ?></p>
                                    <p class="margin-top-bottom-12">No Hp</p>
                                    <p class="margin-top-bottom-12 font-weight-bold"><?= Account::Get('no_hp') ?></p>
                                </div>
                            </div>
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
                                    <h3 class="float-right"><?=App::price($data['harga'])?> / Bulan</h3>
                                    <h3 class="blog-title py-2 py-sm-3 inline"><?= $data['nama_kos'] ?></h3>
                                    <h5 class="margin-top-bottom-12">Tersedia <?= $data['jumlah_kamar']?> kamar</h5>
                                    <div class="row">
                                        <div class="col-md-8">
                                            Pembayaran DP 
                                            <!-- <span>*dp yang harus dibayarkan</span> -->
                                        </div>
                                        <div class="col-md-4">
                                            <h3 class="float-right color-primary"><?= App::price(25/100 * $data['harga']) ?></h3>
                                        </div>
                                    </div>
                                    <div class="meta-info d-flex flex-wrap align-items-center py-2">
                                        <ul>
                                            <li class="d-inline-block p-2">Pemilik Kos <b><?= $data['nama_pemilik'] ?></b></li>
                                            <li class="d-inline-block p-2">Tanggal Pemesanan <?= App::date($data['tanggal_pemesanan'], "d M Y, H:i") ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <?php 
                                if($data['status_code']  == '1' || $data['status_code']  == '2'){
                                ?>
                                <div class="col-md-6">
                                    <h3 class="margin-top-bottom-12">Pembayaran Melalui Rekening</h3>
                                    <p class="margin-top-bottom-12">BNI 66176672676 (Papikos)</p>
                                </div>
                                <?php 
                                if($data['status_code'] == '1'){
                                ?>
                                <div class="col-md-6">
                                    <p style="text-align:right">Batas maksimal pembayaran dp 1 x 24 jam</p>
                                    <a href="<?= BASEURL."pemesanan/bayar/".$data['id']."/".$data['status_code'] ?>" class='bayar'><button class="btn btn-success float-right" >Bayar Dp</button></a>
                                </div>
                                <?php }else if($data['status_code'] == 2){ ?>
                                <div class="col-md-6">
                                    <p style="text-align:right">Batas maksimal pembayaran Pelunasan 3 x 24 jam</p>
                                    <a href="<?= BASEURL."pemesanan/bayar/".$data['id']."/".$data['status_code'] ?>" class='bayar'><button class="btn btn-success float-right" >Bayar Pelunasan</button></a>
                                </div>
                                <?php }}else{
                                $pesan = "";
                                $alert = "";
                                if($data['status_code'] == '0'){
                                    $pesan = "Pesanan anda dibatalkan";
                                    $alert = "danger";
                                }else if($data['status_code'] == 2){
                                    $pesan = "Terimakasih anda sudah membayar dp kos. segera bayar pelunasan kos anda";
                                    $alert = "success";
                                }else if($data['status_code'] == 3){
                                    $pesan = "Terimakasih anda sudah melunasi kos";
                                    $alert = "success";
                                }
                                ?>
                                <div style="margin-top:12px;" class="col-md-12 text-center font-weight-bold alert alert-<?= $alert ?>">
                                    <?= $pesan ?>
                                </div>
                                <?php } ?>
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