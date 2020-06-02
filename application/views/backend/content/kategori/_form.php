<div class="page-content-wrapper-inner">
    <?php Response_Helper::breadcrumb()?>
    <div class="content-viewport">
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <p class="grid-header">Tambah kategori</p>
                    <div class="grid-body">
                        <div class="item-wrapper">
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="inputEmail1">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="<?=Input_Helper::postOrOr('nama', $data['nama'])?>" placeholder="Masukkan nama kategori">
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