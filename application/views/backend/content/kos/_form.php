<div class="page-content-wrapper-inner">
    <?php App::breadcrumb()?>
    <div class="content-viewport">
        <form method="post" action="#" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-12 equel-grid">
                    <div class="grid">
                        <p class="grid-header">Tambah Kos</p>
                        <div class="grid-body">
                            <div class="item-wrapper">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail1">Nama</label>
                                        <input type="text" id="nama" name="nama" class="form-control" value="<?=Input::postOrOr('nama', $data['nama'])?>" placeholder="Masukkan nama kos" required>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label for="inputPassword1">Jenis Kos</label>
                                        <select class="custom-select" name="jenis" id="jenis" required>
                                        <option value=' '>Pilih Jenis</option>
                                        <?php
                                        $jen = Input::postOrOr('jenis', $data['jenis']);
                                        ?>
                                            <option <?=($jen == '1' ? 'selected' : '')?> value='1'>Laki laki</option>
                                            <option <?=($jen == '2' ? 'selected' : '')?> value='2'>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputPassword1">Deskripsi</label>
                                        <textarea name="deskripsi" id="ckedtor deskripsi" name="deskripsi" class=" ckeditor form-control" cols="30" rows="10" required><?=Input::postOrOr('deskripsi', $data['deskripsi'])?></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputPassword1">Kategori</label>
                                        <select class="custom-select" name="kategori" id="kategori" required>
                                        <option value=' '>Pilih Kategori</option>
                                        <?php
                                        $kat = Input::postOrOr('kategori', $data['id_kategori']);
                                        foreach($kategori as $k){
                                        ?>
                                            <option <?=($k['id'] == $kat ? 'selected' : '')?> value='<?= $k['id'] ?>'><?= $k['nama'] ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <p><b>Lokasi Kos</b></p>
                                        <div class="grid-body">
                                            <div class="item-wrapper">
                                                <div class="alert alert-info"><b>Info</b>. pilih lokasi kos anda</div>
                                                <div id="map">
                                                                        
                                                </div>                    
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-lg-12 equel-grid">
                    <div class="grid">
                        <p class="grid-header">Detail Kos</p>
                        <div class="grid-body">
                            <div class="row detail">
                            <?php 
                            if($type == 'Edit'){
                                foreach ($detail as $d) {
                            ?>
                                <div class="col-md-12 detail-item">
                                    <div class=" float-right">
                                        <button class="btn btn-sm btn-danger"><i class="mdi mdi-close"></i></button>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword1">Type Kos</label>
                                            <input type="hidden" name="id[]" value="<?=Input::postOrOr('id', $d['id'])?>">
                                            <input type="number" min="1" id="type" name="type[]" class="form-control" value="<?=Input::postOrOr('type', $d['type'])?>"  placeholder="Masukkan type kamar kos">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword1">Jumlah Kamar</label>
                                            <input type="number" min="1" id="jumlah_kamar" name="jumlah_kamar[]" class="form-control" value="<?=Input::postOrOr('jumlah_kamar', $d['jumlah_kamar'])?>"  placeholder="Masukkan jumlah kamar kos">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword1">Harga</label>
                                            <input type="number" min="1" name="harga[]" id="harga" class="form-control" value="<?=Input::postOrOr('harga', $d['harga'])?>" placeholder="Masukkan harga kos">
                                        </div>
                                        <div class="item-wrapper col-md-6">
                                            <p>Foto / Video</p>
                                            <input type="hidden" value="<?= $d['id'] ?>" id="id">
                                            <div class="alert alert-warning"><b>Perhatian</b>. unggah file dengan type png, jpg, dan jpeg </div>
                                            <!-- untuk video dengan type mp4 dengan ukuran maksimal 4MB -->
                                            <!-- <div class="dropzone dropzone-previews">
                                                <div class="fallback"> -->
                                                    <input name="file[]" type="file" multiple <?= ($type == "Edit" ? '' : "required")?>/>
                                                <!-- </div>
                                            </div> -->
                                        </div>
                                        <?php 
                                            if($type != 'Edit'){
                                        ?>
                                        <div class="item-wrapper col-md-12">
                                            <label for="">Fasilitas</label>
                                            <div class="row">
                                                <?php 
                                                    foreach ($subfas as $sf) {
                                                ?>
                                                <div class="form-group col-md-6">
                                                    <label><?= $sf['nama'] ?></label>
                                                    <div class="row">
                                                        <?php 
                                                        if ($sf['sub'][0] != '') {
                                                            foreach($sf['old_sub'] as $s)
                                                                echo "<input type='hidden' class='old_sub_fasilitas' name='old_sub_fasilitas[0][]' value='$s'>";
                                                            foreach ($sf['sub'] as $sub) {
                                                        ?>
                                                        <div class="col-md-6">
                                                            <input type="checkbox" class="sub_fasilitas" name="sub_fasilitas[0][]" <?= ((in_array($sub['id'], $sf['old_sub']) ? 'checked' : '')) ?> value="<?= $sub['id'] ?>"> <?= $sub['nama'] ?>
                                                        </div>
                                                        <?php }}else{
                                                            echo "<div class='alert alert-warning alert-block'>sub fasilitas tidak ada</div> ";
                                                        } ?>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <hr>
                                </div>
                            <?php } } else{
                                ?>
                                <div class="col-md-12 detail-item">
                                    <div class=" float-right">
                                        <button class="btn btn-sm btn-danger"><i class="mdi mdi-close"></i></button>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword1">Type Kos</label>
                                            <input type="number" min="1" id="type" name="type[]" class="form-control" value="<?=Input::postOrOr('type', $d['type'])?>"  placeholder="Masukkan type kamar kos">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword1">Jumlah Kamar</label>
                                            <input type="number" min="1" id="jumlah_kamar" name="jumlah_kamar[]" class="form-control" value="<?=Input::postOrOr('jumlah_kamar', $d['jumlah_kamar'])?>"  placeholder="Masukkan jumlah kamar kos">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword1">Harga</label>
                                            <input type="number" min="1" name="harga[]" id="harga" class="form-control" value="<?=Input::postOrOr('harga', $d['harga'])?>" placeholder="Masukkan harga kos">
                                        </div>
                                        <div class="item-wrapper col-md-6">
                                            <p>Foto / Video</p>
                                            <input type="hidden" value="<?= $d['id'] ?>" id="id">
                                            <div class="alert alert-warning"><b>Perhatian</b>. unggah file dengan type png, jpg, dan jpeg </div>
                                            <!-- untuk video dengan type mp4 dengan ukuran maksimal 4MB -->
                                            <!-- <div class="dropzone dropzone-previews">
                                                <div class="fallback"> -->
                                                    <input name="file[]" type="file" multiple required/>
                                                <!-- </div>
                                            </div> -->
                                        </div>
                                        <?php 
                                            if($type != 'Edit'){
                                        ?>
                                        <div class="item-wrapper col-md-12">
                                            <label for="">Fasilitas</label>
                                            <div class="row">
                                                <?php 
                                                    foreach ($subfas as $sf) {
                                                ?>
                                                <div class="form-group col-md-6">
                                                    <label><?= $sf['nama'] ?></label>
                                                    <div class="row">
                                                        <?php 
                                                        if ($sf['sub'][0] != '') {
                                                            foreach($sf['old_sub'] as $s)
                                                                echo "<input type='hidden' class='old_sub_fasilitas' name='old_sub_fasilitas[0][]' value='$s'>";
                                                            foreach ($sf['sub'] as $sub) {
                                                        ?>
                                                        <div class="col-md-6">
                                                            <input type="checkbox" class="sub_fasilitas" name="sub_fasilitas[0][]" <?= ((in_array($sub['id'], $sf['old_sub']) ? 'checked' : '')) ?> value="<?= $sub['id'] ?>"> <?= $sub['nama'] ?>
                                                        </div>
                                                        <?php }}else{
                                                            echo "<div class='alert alert-warning alert-block'>sub fasilitas tidak ada</div> ";
                                                        } ?>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <hr>
                                </div>
                                <?php } ?>

                            </div>
                            <div class="form-group" style="float:right!important">
                                <button class="btn btn-info pull-right btn-sm duplicate" type="button">Tambah Detail Kos</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="equal-grid">
                <button type="submit" class="simpan btn btn-sm btn-primary pull-right <?= ($type != 'Tambah' ? 'update' : '')  ?>" ><?=$type?></button>
                </div>
            </div>
        </form>
    </div>
</div>