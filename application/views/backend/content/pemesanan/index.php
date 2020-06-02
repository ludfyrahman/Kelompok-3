<div class="page-content-wrapper-inner">
  <?php Response_Helper::breadcrumb()?>
  <div class="content-viewport">
    <div class="row">
      
      <div class="col-lg-12">
        <div class="grid">
          <p class="grid-header"><?= $title ?>  </p>
          <?php Response_Helper::part('alert');?>
            <div class="row">
              <div class="form-group col-md-3">
                <input type="date" id="start_date" class="form-control" placeholder="Tanggal Awal" value="<?php echo Input_Helper::getOr('start_date', date('Y-m-d', strtotime('-6 days'))) ?>">
              </div>
              <div class="form-group col-md-3">
                <input type="date" id="end_date" class="form-control" placeholder="Tanggal Akhir" value="<?php echo Input_Helper::getOr('end_date', date('Y-m-d')) ?>">
              </div>
              <div class="form-group col-md-3">
                <select id="status" class="form-control">
                  <option value="">Pilih Status</option>
                  <?php 
                  $st = Input_Helper::getOr('status');
                  if ($st == '') {
                    $st = 4;
                  }
                    foreach (status_pemesanan as $key => $val) {
                      ?>
                      <option <?= $st == $key ? 'selected' : '' ?> value="<?= $key ?>"><?= $val ?></option>
                    <?php } ?>

                </select>
              </div>
              <div class="col-md-1">
                <input type="submit" class="btn btn-primary btn-sm btn-filter-pemesanan" name="cari" value="Filter">
              </div>
            </div>
          <div class="item-wrapper">
            <div class="table-responsive">
              <table class="table info-table table-striped">
                <thead>
                  <tr>
                    <th>Kode Pemesanan</th>
                    <th class='text-left'>Nama Pemesan</th>
                    <th class='text-left'>Nama Kos</th>
                    <th class='text-left'>Status</th>
                    <th class='text-left'>Tanggal Pemesanan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($list as $l){
                  ?>
                  <tr>
                    <td><a href="<?= BASEADM."pemesanan/$l[id]/detail" ?>"><?= invoice_code."$l[id]"?></a></td>
                    <td class='text-left'><?=$l['nama_pemesan']?></td>
                    <td class='text-left'><?=$l['nama_kos']?></td>
                    <td class='text-left'><?=$l['status']?></td>
                    <td class='text-left'><?= Response_Helper::Date($l['tanggal_pemesanan'])?></td>
                    <td>
                    <?php 
                    if($l['status_code'] == 1){
                    ?>
                    <a href="<?=BASEADM.'pemesanan/aksi/'.$l['status_code'].'/'.$l['id'] ?>" >
                      <button class="btn btn-primary btn-sm">Terima</button>
                    </a>
                    <a href="<?=BASEADM.'pemesanan/aksi/'.$l['status_code'].'/'.$l['id'] ?>" >
                      <button class="btn btn-danger btn-sm">Tolak</button>
                    </a>
                    <?php } ?>  
                    </td>
                  </tr>
                <?php $no++;} ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>