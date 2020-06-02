<div class="page-content-wrapper-inner">
  <?php Response_Helper::breadcrumb()?>
  <div class="content-viewport">
    <div class="row">
      
      <div class="col-lg-12">
        <div class="grid">
          <p class="grid-header"><?= $title ?> <a href="<?=BASEADM."sub_fasilitas/add"?>"><button class="btn btn-primary float-right">Tambah</button></a></p>
          <?php Response_Helper::part('alert');?>
          <div class="item-wrapper">
            <div class="table-responsive">
              <table class="table info-table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th class='text-left'>Nama</th>
                    <th class='text-left'>Fasilitas</th>
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
                    <td class='text-left'><?=$l['fasilitas']?></td>
                    <td>
                      <a href="<?=BASEADM.'sub_fasilitas/edit/'.$l['id']?>" >
                        <i class="mdi mdi-pencil-box-outline"></i>
                      </a>
                      <a href="<?=BASEADM.'sub_fasilitas/delete/'.$l['id'] ?>" >
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