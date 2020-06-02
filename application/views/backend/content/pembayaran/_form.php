<div class="page-content-wrapper-inner">
    <?php Response_Helper::breadcrumb()?>
    <div class="content-viewport">
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <p class="grid-header">Tambah pengguna</p>
                    <div class="grid-body">
                        <div class="item-wrapper">
                            <form method="post" action="" enctype="multipart/form-data">
                            <?php Response_Helper::part('alert');?>
                                <div class="form-group">
                                    <label for="inputEmail1">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="<?=Input_Helper::postOrOr('nama', $data['nama'])?>" placeholder="Masukkan nama pengguna" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?=Input_Helper::postOrOr('email', $data['email'])?>" placeholder="Masukkan email pengguna" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1">No Hp</label>
                                    <input type="text" name="no_hp" class="form-control" value="<?=Input_Helper::postOrOr('no_hp', $data['no_hp'])?>" placeholder="Masukkan No Hp pengguna" required>
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
                                <button type="submit" class="btn btn-sm btn-primary"><?=$type?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>