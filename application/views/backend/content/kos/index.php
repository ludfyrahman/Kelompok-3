<div class="page-content-wrapper-inner">
  <?php App::breadcrumb()?>
  <div class="content-viewport">
    <div class="row">
      
      <div class="col-lg-12">
        <div class="grid">
          <p class="grid-header">Daftar Kos <a href="<?=BASEADM."kost/add"?>"><button class="btn btn-primary float-right">Tambah</button></a></p>
          <?php Response::part('alert');?>
          <div class="item-wrapper">
            <div class="table-responsive">
              <table class="table info-table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th class='text-left'>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Profit</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($list as $l){
                  ?>
                  <tr>
                    <td><?=$no?></td>
                    <td class='text-left'><?=$l['nama']?></td>
                    <td><?=$l['nama_kategori']?></td>
                    <td><?= App::price($l['harga'])?></td>
                    <td>
                      <a href="<?=BASEADM.'kost/'.$l['id'].'/edit' ?>" >
                        <i class="mdi mdi-pencil-box-outline"></i>
                      </a>
                      <a href="<?=BASEADM.'kost/'.$l['id'].'/delete' ?>" >
                        <i class="mdi mdi-delete-forever"></i>
                      </a>
                      <a href="<?=BASEURL.'kos/detail/'.$l['id'].'' ?>" target="_blank">
                        <i class="mdi mdi-book"></i>
                      </a>

                    </td>
                    <td class="actions">
                      <i class="mdi mdi-dots-vertical"></i>
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