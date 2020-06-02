<div class="page-content-wrapper-inner">
  <?php Response_Helper::breadcrumb()?>
  <div class="content-viewport">
    <div class="row">
      
      <div class="col-lg-12">
        <div class="grid">
          <?php Response_Helper::part('alert');?>
          <form action="" method="post">
            <div class="row">
              <div class="form-group col-md-5">
                <input type="date" name="start_date" class="form-control" placeholder="Tanggal Awal" value="<?= (Input_Helper::postOrOr('start_date')) ?>">
              </div>
              <div class="col-md-1">
                sampai
              </div>
              <div class="form-group col-md-5">
                <input type="date" name="end_date" class="form-control" placeholder="Tanggal Akhir" value="<?= (Input_Helper::postOrOr('end_date')) ?>">
              </div>
              <div class="col-md-1">
                <input type="submit" class="btn btn-primary btn-sm" name="cari" value="Filter">
              </div>
            </div>
          </form>
          <div class="item-wrapper">
            <div class="table-responsive">
              <table class="table info-table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th class='text-left'>Tanggal</th>
                    <th class='text-left'>Ditolak</th>
                    <th class='text-left'>Pending</th>
                    <th class='text-left'>Dp</th>
                    <th class='text-left'>lunas</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  // print_r($list['tgl']);
                  foreach($list as $l){
                  ?>
                  <tr>
                    <td><?=$no?></td>
                    <td class='text-left'><?=$l['tgl']?></td>
                    <td class='text-left'><b><a href="<?= BASEADM."pemesanan&start_date=".$l['tgl']."&end_date=".$l['tgl']."&status=0" ?>"><?=$l['ditolak']?></b></a></td>
                    <td class='text-left'><b><a href="<?= BASEADM."pemesanan&start_date=".$l['tgl']."&end_date=".$l['tgl']."&status=1" ?>"><?=$l['pending']?></b></a></td>
                    <td class='text-left'><b><a href="<?= BASEADM."pemesanan&start_date=".$l['tgl']."&end_date=".$l['tgl']."&status=2" ?>"><?=$l['dp']?></b></a></td>
                    <td class='text-left'><b><a href="<?= BASEADM."pemesanan&start_date=".$l['tgl']."&end_date=".$l['tgl']."&status=3" ?>"><?=$l['lunas']?></b></a></td>
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