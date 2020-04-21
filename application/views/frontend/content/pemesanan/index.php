<!-- ***** Blog Area Start ***** -->
<section id="blog" class="section blog-area ptb_100">
    <div class="container">
        <div class="row">
            <?php
            Response::part('sidebar_profile');
            ?>
            <div class="col-12 col-lg-9">
                <article class="single-blog-details">
                    <h2 class="margin-top-bottom-12">Daftar Transaksi</h2>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="informasi-tab" data-toggle="tab" href="#dp" role="tab" aria-controls="dp" aria-selected="true"><i class="fa fa-clipboard-list"></i>  Menunggu Pembayaran Dp</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ulasan-tab" data-toggle="tab" href="#pelunasan" role="tab" aria-controls="pelunasan" aria-selected="false"><i class="fa fa-swatchbook"></i> Menunggu Pelunasan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ulasan-tab" data-toggle="tab" href="#dibatalkan" role="tab" aria-controls="dibatalkan" aria-selected="false"><i class="fa fa-swatchbook"></i> Dibatalkan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ulasan-tab" data-toggle="tab" href="#lunas" role="tab" aria-controls="lunas" aria-selected="false"><i class="fa fa-swatchbook"></i> Lunas</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="dp" role="tabpanel" aria-labelledby="informasi-tab">
                            <div class="container">
                                <?php 
                                foreach ($dp as $d) {
                                ?>
                                <div class="margin-top-bottom-12 card-shadow">
                                    <h4 class="margin-top-bottom-12"><?= $d['nama'] ?></h4>
                                    <p class="margin-top-bottom-12">Total : <b class="color-primary"><?= App::price($d['harga']) ?></b> Tanggal Pembelian : <b><?= App::Date($d['tanggal_pemesanan'], 'd M Y') ?></b></p>
                                    <div class="alert alert-warning margin-top-bottom-12">
                                        <p>Bayar Sebelum <?= (date('d M Y H:i:s', strtotime($d['tanggal_pemesanan']. ' +1 day')))?></p>
                                    </div>
                                    <p class="margin-top-bottom-12">Kode Pemesanan : <a href="<?= BASEURL."akun/pemesanan/detail/".$d['id_pemesanan'] ?>"><b><?= invoice_code."".$d['id_pemesanan'] ?></b></a></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pelunasan" role="tabpanel" aria-labelledby="ulasan-tab">
                            <div class="container">
                                <?php 
                                foreach ($lunas as $p) {
                                ?>
                                <div class="margin-top-bottom-12 card-shadow">
                                    <h4 class="margin-top-bottom-12"><?= $p['nama'] ?></h4>
                                    <p class="margin-top-bottom-12">Total : <b class="color-primary"><?= App::price($p['harga']) ?></b> Tanggal Pembelian : <b><?= App::Date($p['tanggal_pemesanan'], 'd M Y') ?></b></p>
                                    <div class="alert alert-warning margin-top-bottom-12">
                                        <p>Bayar Sebelum <?= (date('d M Y H:i:s', strtotime($p['tanggal_pemesanan']. ' +4 day')))?></p>
                                    </div>
                                    <p class="margin-top-bottom-12">Kode Pemesanan : <a href="<?= BASEURL."akun/pemesanan/detail/".$p['id_pemesanan'] ?>"><b><?= invoice_code."".$p['id_pemesanan'] ?></b></a></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="dibatalkan" role="tabpanel" aria-labelledby="ulasan-tab">
                            <div class="container">
                                <?php 
                                foreach ($dibatalkan as $b) {
                                ?>
                                <div class="margin-top-bottom-12 card-shadow">
                                    <h4 class="margin-top-bottom-12"><?= $b['nama'] ?></h4>
                                    <p class="margin-top-bottom-12">Total : <b class="color-primary"><?= App::price($b['harga']) ?></b> Tanggal Pembelian : <b><?= App::Date($b['tanggal_pemesanan'], 'd M Y') ?></b></p>
                                    <div class="alert alert-danger margin-top-bottom-12">
                                        <p>Dibatalkan</p>
                                    </div>
                                    <p class="margin-top-bottom-12">Kode Pemesanan : <a href="<?= BASEURL."akun/pemesanan/detail/".$b['id_pemesanan'] ?>"><b><?= invoice_code."".$b['id_pemesanan'] ?></b></a></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="lunas" role="tabpanel" aria-labelledby="ulasan-tab">
                            <div class="container">
                                <?php 
                                foreach ($selesai as $l) {
                                ?>
                                <div class="margin-top-bottom-12 card-shadow">
                                    <h4 class="margin-top-bottom-12"><?= $l['nama'] ?></h4>
                                    <p class="margin-top-bottom-12">Total : <b class="color-primary"><?= App::price($l['harga']) ?></b> Tanggal Pembelian : <b><?= App::Date($l['tanggal_pemesanan'], 'd M Y') ?></b></p>
                                    <div class="alert alert-success margin-top-bottom-12">
                                        <p>Sudah Dibayarkan</p>
                                    </div>
                                    <p class="margin-top-bottom-12">Kode Invoice : <a href="<?= BASEURL."akun/pemesanan/detail/".$l['id_pemesanan'] ?>"><b><?= invoice_code."".$l['id_pemesanan'] ?></b></a><a href="#" id_kos="<?= $l['id_kos'] ?>"  id="open_ulasan_model" class="float-right">Ulasan</a></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="ulasan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ulasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" >
      
        <div class="modal-body text-center">
            <p>Ulasan anda</p>
            <div class="form_ulasan">
                <input type="hidden" id="id_kos">
                <input type="hidden" id="rating" value="1">
                <div class="form-group">
                    <h3 for="" style="margin:20px">Rating</h3>
                    <a href="#" id="rate" val="1"><i class="fa fa-star" ></i></a>
                    <a href="#" id="rate" val="2"><i class="fa fa-star" ></i></a>
                    <a href="#" id="rate" val="3"><i class="fa fa-star" ></i></a>
                    <a href="#" id="rate" val="4"><i class="fa fa-star" ></i></a>
                    <a href="#" id="rate" val="5"><i class="fa fa-star" ></i></a>
                </div>
                <div class="form-group">
                    <h3>Ulasan</h3>
                    <textarea name="ulasan" placeholder="ulasan anda untuk kos" class="form-control" id="ulasan" cols="30" rows="10"></textarea>
                </div>
                
                <button type="button" id="simpan_ulasan" class="btn btn-success btn-block">Ulasan</button>
            </div>
            <div class="result_ulasan">
                
            </div>
        </div>
    </form>
    </div>
  </div>
</div>
<!-- ***** Blog Area End ***** -->