<div class="page-content-wrapper-inner">
    <?php Response_Helper::breadcrumb()?>
    <div class="content-viewport">
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <p class="grid-header"><?= $title ?></p>
                    <div class="grid-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Kode Invoice: <?= invoice_code."".$data['id'] ?></h2>
                                <span class="badge badge-<?= status[$data['status_code']]?>"><?= $data['status'] ?></span>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <p><?= $data['nama'] ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">No HP</label>
                                    <p><?= $data['no_hp'] ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <p><?= $data['alamat'] ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Rekening</label>
                                    <p><?= ($data['nama_rekening'] == '' ? '-' : $data['nama_rekening']) ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Bank</label>
                                    <p><?= ($data['nama_bank'] == '' ? '-' : $data['nama_bank']) ?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">No Rekening</label>
                                    <p><?= ($data['no_rekening'] == '' ? '-' : $data['no_rekening']) ?></p>
                                </div>

                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Pemilik</label>
                                    <p><?= $data['nama_pemilik']?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Kos</label>
                                    <p><?= $data['nama_kos']?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Harga</label>
                                    <p><?= Response_Helper::price($data['harga'])?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Jumlah Kamar</label>
                                    <p><?= $data['jumlah_kamar']." kamar"?></p>
                                </div>
                                <div class="form-group">
                                    <label for="">Jumlah Kamar</label>
                                    <p><?= $data['nama_kos']?></p>
                                </div>
                            </div>
                            <h1>Pembayaran</h1>
                            <?php 
                            foreach ($pembayaran as $p) {
                                ?>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">Bukti Bayar</label>
                                            <p><img src="<?= BASEASSET."images/upload/bukti/$p[bukti_bayar]" ?>" class="img-fluid" alt=""></p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Jumlah Bayar</label>
                                                        <p><?= Response_Helper::price($p['jumlah'])?></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Jenis Bayar</label><br>
                                                        <p class="badge badge-success"><?= tipe_pembayaran[$p['tipe']]?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Tanggal Bayar</label>
                                                        <p><?= Response_Helper::date($p['tanggal_pembayaran'])?></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Status Bayar</label>
                                                        <p><?= ($p['status'] == 1 ? 'Dikonfirmasi' : 'belum dikonfirmasi')?></p>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php
                                            if($p['status'] == 0){
                                            ?>
                                            <a href="<?= BASEADM."pembayaran/aksi/".$p['tipe']."/".$p['id']."" ?>"><button class="mdi-delete-forever btn btn-primary">Konfirmasi</button></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>