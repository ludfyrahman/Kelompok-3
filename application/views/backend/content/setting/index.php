<div class="page-content-wrapper-inner">
    <?php Response_Helper::breadcrumb()?>
    <div class="content-viewport">
        <div class="row">
            <div class="col-lg-6 equel-grid">
                <div class="grid">
                    <p class="grid-header">Gmail</p>
                    <div class="grid-body">
                        <div class="item-wrapper">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputEmail1">Email</label>
                                    <input type="text" name="email" class="form-control" value="<?=Input_Helper::postOrOr('email', $gmail['email'])?>" placeholder="Masukkan Email Papikos">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">Api Key</label>
                                    <input type="text" name="api_key" class="form-control" value="<?=Input_Helper::postOrOr('api_key', $gmail['api_key'])?>" placeholder="Masukkan Api Key Papikos">
                                </div>
                                <h5>Deskripsi</h5>
                                <div class="container">
                                    <div class="form-group">
                                        <label for="inputEmail1">Lupa Password</label>
                                        <textarea name="" class="form-control" id="ckedtor" placeholder="Deskripsi Lupa Password" cols="30" rows="10"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Notifikasi Pembayaran</label>
                                        <textarea name="" class="form-control" id="ckedtor" placeholder="Deskripsi Notifikasi Pembayaran" cols="30" rows="10"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Notifikasi Konfirmasi Akun</label>
                                        <textarea name="" class="form-control" id="ckedtor" placeholder="Deskripsi Notifikasi Konfirmasi Akun" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 equel-grid">
                <div class="grid">
                    <p class="grid-header">Facebook</p>
                    <div class="grid-body">
                        <div class="item-wrapper">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputEmail1">Nama Tampilan</label>
                                    <input type="text" name="nama" class="form-control" value="<?=Input_Helper::postOrOr('nama', $gmail['nama'])?>" placeholder="Masukkan Nama Tampilan Papikos">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">Domain Aplikasi</label>
                                    <input type="text" name="domain_aplikasi" class="form-control" value="<?=Input_Helper::postOrOr('domain_aplikasi', $gmail['domain_aplikasi'])?>" placeholder="Masukkan Domain Aplikasi Papikos">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">Email</label>
                                    <input type="text" name="domain_aplikasi" class="form-control" value="<?=Input_Helper::postOrOr('domain_aplikasi', $gmail['domain_aplikasi'])?>" placeholder="Masukkan Email Papikos">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">ID Aplikasi</label>
                                    <input type="text" name="api_key" class="form-control" value="<?=Input_Helper::postOrOr('api_key', $gmail['api_key'])?>" placeholder="Masukkan ID Aplikasi Papikos">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">Api Key</label>
                                    <input type="text" name="api_key" class="form-control" value="<?=Input_Helper::postOrOr('api_key', $gmail['api_key'])?>" placeholder="Masukkan Api Key Papikos">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">Ikon Aplikasi</label><br>
                                    <input type="file" name="domain_aplikasi" value="<?=Input_Helper::postOrOr('domain_aplikasi', $gmail['domain_aplikasi'])?>" placeholder="Masukkan Email Papikos">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 equel-grid">
                <div class="grid">
                    <p class="grid-header">Google Map</p>
                    <div class="grid-body">
                        <div class="item-wrapper">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputEmail1">Api Key</label>
                                    <input type="text" name="api_key" class="form-control" value="<?=Input_Helper::postOrOr('api_key', $gmail['api_key'])?>" placeholder="Masukkan Api Key Papikos">
                                </div>
                                <div id="map">
                                                        
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 equel-grid">
                <div class="grid">
                    <p class="grid-header">Notifikasi Sms</p>
                    <div class="grid-body">
                        <div class="item-wrapper">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputEmail1">Api Key</label>
                                    <input type="text" name="api_key" class="form-control" value="<?=Input_Helper::postOrOr('api_key', $gmail['api_key'])?>" placeholder="Masukkan Api Key Papikos">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">Api Secret</label>
                                    <input type="text" name="api_secret" class="form-control" value="<?=Input_Helper::postOrOr('api_secret', $gmail['api_secret'])?>" placeholder="Masukkan Api Secret Papikos">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>