<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $title ?>
        <!-- <small>Preview</small> -->
      </h1>
      <?php Response_Helper::part('breadcrumb') ?>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><?= $this->uri->segment(3) ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <?php Response_Helper::part('alert') ?>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="" method="post">
            <div class="row">
              <div class="form-group col-md-6">
                  <label>Jenis</label>
                  <h4><?= $data['jenis'] ?></h4>
              </div>
              <div class="form-group col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Aktif</label>
                      <h4><?= $data['aktif'] ?></h4>
                    </div>
                    <div class="col-md-6">
                      <label>Inaktif</label>
                      <h4><?= $data['inaktif'] ?></h4>
                    </div>
                  </div>
              </div>
              <div class="form-group col-md-12">
                  <label>Parent</label>
                  <h4><?= ($parent['jenis'] == "" ? "-" : $parent['jenis']) ?></h4>
              </div>
              <div class="form-group col-md-12">
                  <label>Keterangan</label>
                  <h5><?= $data['keterangan'] ?></h5>
              </div>              
            </div>
          </form>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer">
          Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
          the plugin.
        </div> -->
      </div>
      <!-- /.box -->


    </section>
    <!-- /.content -->
  </div>