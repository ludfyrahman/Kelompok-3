<div class="page-content-wrapper-inner">
    <?php Response_Helper::breadcrumb()?>
    <div class="content-viewport">
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <p class="grid-header">Tambah fasilitas</p>
                    <div class="grid-body">
                        <div class="item-wrapper">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputEmail1">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="<?=Input_Helper::postOrOr('nama', $data['nama'])?>" placeholder="Masukkan nama fasilitas">
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword1">Fasilitas</label>
                                    <select class="custom-select" name="fasilitas" id="fasilitas">
                                    <option value=' '>Pilih Fasilitas</option>
                                    <?php
                                    $kat = Input_Helper::postOrOr('fasilitas', $data['id_fasilitas']);
                                    foreach($fasilitas as $k){
                                    ?>
                                        <option <?=($k['id'] == $kat ? 'selected' : '')?> value='<?= $k['id'] ?>'><?= $k['nama'] ?></option>
                                    <?php } ?>
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