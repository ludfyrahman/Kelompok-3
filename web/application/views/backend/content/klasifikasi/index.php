<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $title ?>
        <!-- <small>advanced tables</small> -->
      </h1>
     <?php Response_Helper::part('breadcrumb') ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?= $title ?></h3>
              <a href="<?= base_url('admin')."/".$this->uri->segment(2)."/add" ?>">
                <button class="btn btn-primary pull-right">Tambah</button>
              </a>
            </div>
            <?php Response_Helper::part('alert') ?>
            <!-- /.box-header -->
            <?php 
            $field = "
            <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Level</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
            ";
            ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <?= $field ?>
                </thead>
                <tbody>
                  <?php 
                  $no = 1;
                  foreach ($data as $d) {
                    ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $d['nama'] ?></td>
                    <td><?= $d['email'] ?></td>
                    <td><?= LEVEL[$d['level']] ?></td>
                    <td><?= STATUS_PENGGUNA[$d['status']] ?></td>
                    <td>
                        <a href="<?= base_url('admin/pengguna/delete/'.$d['id']) ?>" class="delete"><span class="badge bg-red"><i class="fa fa-trash"></i></span></a>
                        <a href="<?= base_url('admin/pengguna/edit/'.$d['id']) ?>"><span class="badge bg-yellow"><i class="fa fa-pencil"></i></span></a>
                        <!-- <a href="<?= base_url('admin/pengguna/detail/'.$d['id']) ?>"><span class="badge bg-blue"><i class="fa fa-book"></i></span></a> -->
                    </td>
                  </tr>
                  <?php $no++;} ?>
                </tbody>
                <tfoot>
                <?= $field ?>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>