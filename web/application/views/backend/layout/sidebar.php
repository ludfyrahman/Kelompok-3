<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url() ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?= ($this->uri->segment(2) == "dashboard" ? 'active' : '') ?>">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="<?= ($this->uri->segment(2) == "pengguna" ? 'active' : '') ?>">
          <a href="<?= base_url('admin/pengguna') ?>">
            <i class="fa fa-users"></i> <span>Pengguna</span>
            <!-- <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span> -->
          </a>
        </li>
        <li  class="<?= ($this->uri->segment(2) == "jabatan" ? 'active' : '') ?>">
          <a href="<?= base_url('admin/jabatan') ?>">
            <i class="fa fa-user"></i>
            <span>Jabatan</span>
          </a>
        </li>
        <li  class="<?= ($this->uri->segment(2) == "pengirim" ? 'active' : '') ?>">
          <a href="<?= base_url('admin/pengirim') ?>">
            <i class="fa fa-pie-chart"></i>
            <span>Pengirim</span>
          </a>
        </li>
        <li  class="<?= ($this->uri->segment(2) == "sifat" ? 'active' : '') ?>">
          <a href="<?= base_url('admin/sifat') ?>">
            <i class="fa fa-pie-chart"></i>
            <span>Sifat</span>
          </a>
        </li>
        <li  class="<?= ($this->uri->segment(2) == "jenis" ? 'active' : '') ?>">
          <a href="<?= base_url('admin/jenis') ?>">
            <i class="fa fa-pie-chart"></i>
            <span>Jenis</span>
          </a>
        </li>
        <li  class="<?= ($this->uri->segment(2) == "retensi" ? 'active' : '') ?>">
          <a href="<?= base_url('admin/retensi') ?>">
            <i class="fa fa-pie-chart"></i>
            <span>Retensi</span>
          </a>
        </li>
        <li  class="<?= ($this->uri->segment(2) == "klasifikasi" ? 'active' : '') ?>">
          <a href="<?= base_url('admin/klasifikasi') ?>">
            <i class="fa fa-pie-chart"></i>
            <span>Klasifikasi</span>
          </a>
        </li>
        <li class="treeview" class="<?= ($this->uri->segment(2) == "klasifikasi" ? 'active' : '') ?>">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Klasifikasi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li class="treeview" class="<?= ($this->uri->segment(2) == "arsip" ? 'active' : '') ?>">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Arsip</span>
            <span class="pull-right-container">
              <span class="label label-warning pull-right">3</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Masuk</a></li>
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Terkirim</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Draf</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>