<div class="page-content-wrapper-inner">
  <?php App::breadcrumb()?>
  <div class="content-viewport">
    <div class="row">
      
      <div class="col-lg-12">
        <div class="grid">
          <p class="grid-header"><?= $title ?>  </p>
          <?php Response::part('alert');?>
            <div class="row">
              <div class="form-group col-md-3">
                <input type="date" id="start_date" class="form-control" placeholder="Tanggal Awal" value="<?php echo Input::getOr('start_date', date('Y-m-d', strtotime('-6 days'))) ?>">
              </div>
              <div class="form-group col-md-3">
                <input type="date" id="end_date" class="form-control" placeholder="Tanggal Akhir" value="<?php echo Input::getOr('end_date', date('Y-m-d')) ?>">
              </div>
              <div class="form-group col-md-3">
                <select id="status" class="form-control">
                  <option value="">Pilih Status</option>
                  <?php 
                  $st = Input::getOr('status');
                  if ($st == '') {
                    $st = 4;
                  }
                    foreach (tipe_pembayaran as $key => $val) {
                      ?>
                      <option <?= $st == $key ? 'selected' : '' ?> value="<?= $key ?>"><?= $val ?></option>
                    <?php } ?>

                </select>
              </div>
              <div class="col-md-1">
                <input type="submit" class="btn btn-primary btn-sm btn-filter-pembayaran" name="cari" value="Filter">
              </div>
            </div>
          <div class="item-wrapper">
            <div class="table-responsive">
              <table class="table info-table table-striped">
                <thead>
                  <tr>
                    <th>Kode Pemesanan</th>
                    <th class='text-left'>Nama Pemesan</th>
                    <th class='text-left'>Tipe Pembayaran</th>
                    <th class='text-left'>Harga</th>
                    <th class='text-left'>Tanggal Pembayaran</th>
                    <!-- <th></th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($list as $l){
                  ?>
                  <tr>
                    <td><a href="<?= BASEADM."pemesanan/$l[id_pemesanan]/detail" ?>"><?= invoice_code."$l[id]"?></a></td>
                    <td class='text-left'><?=$l['nama_pemesan']?></td>
                    <td class='text-left'><?=tipe_pembayaran[$l['tipe']]?></td>
                    <td class='text-left'><?= App::price($l['harga'])?></td>
                    <td class='text-left'><?= App::Date($l['tanggal_pembayaran'])?></td>
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