<div class="page-content-wrapper-inner">
    <?php Response_Helper::breadcrumb()?>
    <div class="content-viewport">
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <p class="grid-header">Tambah pengguna</p>
                    <form method="post" action="" enctype="multipart/form-data">
                    <?php Response_Helper::part('alert');?>
                        <div class="row">
                            <div class="grid-body col-md-6">
                                <div class="item-wrapper">
                                    <div class="form-group">
                                        <label for="inputEmail1">Nama</label>
                                        <input type="text" name="nama" class="form-control" value="<?=Input_Helper::postOrOr('nama', $data['nama'])?>" placeholder="Masukkan nama pengguna" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?=Input_Helper::postOrOr('email', $data['email'])?>" placeholder="Masukkan email pengguna" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Password</label>
                                        <input type="password" name="password" class="form-control"  placeholder="Masukkan Password" <?= ($type == "Tambah" ? "required" : "") ?>>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Password Konfirmasi</label>
                                        <input type="password" name="password_konfirmasi" class="form-control"  placeholder="Masukkan Password Konfirmasi" <?= ($type == "Tambah" ? "required" : "") ?>>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword1">Level</label>
                                        <select class="custom-select" name="level" required>
                                        <?php
                                        $ket = Input_Helper::postOrOr('level', $data['level']);
                                        ?>
                                            <option value="">Pilih Level</option>
                                            <option <?= ($ket == "1" ? "selected" : "") ?> value="1">Admin</option>
                                            <option <?= ($ket == "2" ? "selected" : "") ?> value="2">Penyewa Kos</option>
                                            <option <?= ($ket == "3" ? "selected" : "") ?> value="3">Pemilik Kos</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword1">Status</label>
                                        <select class="custom-select" name="status" required>
                                        <?php
                                        $status = Input_Helper::postOrOr('status', $data['status']);
                                        ?>
                                            <option value="">Pilih Status</option>
                                            <option <?= ($status == "1" ? "selected" : "") ?> value="1">Aktif</option>
                                            <option <?= ($status == "0" ? "selected" : "") ?> value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-body col-md-6">
                                <div class="item-wrapper">
                                    <div class="form-group">
                                        <label for="inputEmail1">Nik</label>
                                        <input type="text" name="nik" class="form-control" value="<?=Input_Helper::postOrOr('nik', $data['nik'])?>" placeholder="Masukkan Nik pengguna" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">No Hp</label>
                                        <input type="text" name="no_hp" class="form-control" value="<?=Input_Helper::postOrOr('no_hp', $data['no_hp'])?>" placeholder="Masukkan No Hp pengguna" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Jenis Kelamin</label>
                                        <select class="custom-select" name="jenis_kelamin" required>
                                        <?php
                                        $jenkel = Input_Helper::postOrOr('jenis_kelamin', $data['jenis_kelamin']);
                                        ?>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option <?= ($jenkel == "1" ? "selected" : "") ?> value="1">Laki laki</option>
                                            <option <?= ($jenkel == "2" ? "selected" : "") ?> value="2">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" value="<?=Input_Helper::postOrOr('tanggal_lahir', $data['tanggal_lahir'])?>" placeholder="Masukkan Tanggal lahir" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="inputEmail1">Ktp</label>
                                                <input type="file" name="ktp" style="width:100%" <?= ($type == "Tambah" ? "required" : "") ?>>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="inputEmail1">Profil</label>
                                                <input type="file" name="profil" style="width:100%" <?= ($type == "Tambah" ? "required" : "") ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-body col-md-12">
                                <div class="form-group">
                                    <label for="inputEmail1">Alamat</label>
                                    <textarea name="alamat" class="ckeditor form-control" id="ckeditor" cols="30" rows="10"><?=Input_Helper::postOrOr('alamat', $data['alamat'])?></textarea>
                                </div>
                                <h5 class="margin-top-bottom-12">Data Rekening</h5>
                                <div class="item-wrapper">
                                    <div class="form-group">
                                        <label for="inputEmail1">Nama Rekening</label>
                                        <input type="text" name="nama_rekening" class="form-control" value="<?=Input_Helper::postOrOr('nama_rekening', $data['nama_rekening'])?>" placeholder="Masukkan Nama Rekening pengguna" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">No Rekening</label>
                                        <input type="text" name="no_rekening" class="form-control" value="<?=Input_Helper::postOrOr('no_rekening', $data['no_rekening'])?>" placeholder="Masukkan No Rekening pengguna" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1">Nama Bank</label>
                                        <input type="text" name="nama_bank" class="form-control" value="<?=Input_Helper::postOrOr('nama_bank', $data['nama_bank'])?>" placeholder="Masukkan Nama Bank pengguna" required>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-body col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary"><?=$type?></button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>