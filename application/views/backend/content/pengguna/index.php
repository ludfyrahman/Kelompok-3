<div class="page-content-wrapper-inner">
  <?php Response_Helper::breadcrumb()?>
  <div class="content-viewport">
    <div class="row">
      
      <div class="col-lg-12">
        <div class="grid">
          <p class="grid-header"><?= $title ?> <a href="<?=BASEADM."pengguna/add"?>"><button class="btn btn-primary float-right">Tambah</button></a></p>
          <?php Response_Helper::part('alert');?>
          <div class="item-wrapper">
            <div class="table-responsive">
              <table class="table info-table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th class='text-left'>Nama</th>
                    <th class='text-left'>Email</th>
                    <th class='text-left'>No Hp</th>
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
                    <td class='text-left'><?=$l['email']?></td>
                    <td class='text-left'><?=$l['no_hp']?></td>
                    <td>
                      <a href="<?=BASEADM.'pengguna/'.$l['id'].'/edit' ?>" >
                        <i class="mdi mdi-pencil-box-outline"></i>
                      </a>
                      
                      <a href="<?=BASEADM.'pengguna/'.$l['id'].'/delete' ?>" >
                        <i class="mdi mdi-delete-forever"></i>
                      </a>

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