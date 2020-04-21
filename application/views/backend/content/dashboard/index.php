<!-- partial -->
<div class="page-content-wrapper-inner">
    <div class="content-viewport">
    <div class="row">
        <div class="col-12 py-5">
        <h4>Dashboard</h4>
        <p class="text-gray">Selamat Datang, <?= Account_Helper::Get("nama") ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-6 equel-grid">
        <div class="grid">
            <div class="grid-body text-gray">
            <div class="d-flex justify-content-between">
                <p><?= $kos[0]?></p>
               
            </div>
            <p class="text-black">Kos</p>
            <div class="wrapper w-50 mt-4">
                <canvas height="45" id="stat-line_1"></canvas>
            </div>
            </div>
        </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6 equel-grid">
        <div class="grid">
            <div class="grid-body text-gray">
            <div class="d-flex justify-content-between">
                <p><?= $kategori[0]?></p>
                
            </div>
            <p class="text-black">Kategori</p>
            <div class="wrapper w-50 mt-4">
                <canvas height="45" id="stat-line_2"></canvas>
            </div>
            </div>
        </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6 equel-grid">
        <div class="grid">
            <div class="grid-body text-gray">
            <div class="d-flex justify-content-between">
                <p><?= $fasilitas[0]?></p>
               
            </div>
            <p class="text-black">Fasilitas</p>
            <div class="wrapper w-50 mt-4">
                <canvas height="45" id="stat-line_3"></canvas>
            </div>
            </div>
        </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6 equel-grid">
        <div class="grid">
            <div class="grid-body text-gray">
            <div class="d-flex justify-content-between">
                <p><?= $pengguna[0]?></p>
            
            </div>
            <p class="text-black">Pengguna</p>
            <div class="wrapper w-50 mt-4">
                <canvas height="45" id="stat-line_4"></canvas>
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-6 col-md-6 equel-grid">
            <div class="grid">
                <div class="grid-body d-flex flex-column h-100">
                    <div class="wrapper">
                        <div class="d-flex justify-content-between">
                        <div class="split-header">
                            <!-- <img class="img-ss mt-1 mb-1 mr-2" src="../assets/images/social-icons/instagram.svg" alt="instagram"> -->
                            <p class="card-title">Pesanan</p>
                        </div>
                        <div class="wrapper">
                            <button class="btn action-btn btn-xs component-flat pr-0" type="button"><i class="mdi mdi-access-point text-muted mdi-2x"></i></button>
                            <button class="btn action-btn btn-xs component-flat pr-0" type="button"><i class="mdi mdi-cloud-download-outline text-muted mdi-2x"></i></button>
                        </div>
                        </div>
                        <div class="d-flex align-items-end pt-2 mb-4">
                        <h4><?= $jumlah_pesanan_bulan ?></h4>
                        <p class="ml-2 text-muted">Pesanan Bulan Ini</p>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <canvas class="curved-mode" id="order-chart" height="220"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 equel-grid">
            <div class="grid">
                <div class="grid-body">
                <p class="card-title">Pemesanan Berhasil</p>
                <div id="radial-chart"></div>
                <h4 class="text-center"><?= App::price($pemesanan_lunas['jumlah']) ?></h4>
                <p class="text-center text-muted">Uang Dibayarkan</p>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-4 col-md-6 equel-grid">
            <div class="grid">
                <div class="grid-body">
                    <h2 class="grid-title">Kos</h2>
                    <div class="item-wrapper">
                    <canvas id="chartjs-staked-line-chart" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="col-md-12 equel-grid">
            <div class="grid">
                <div class="grid-body py-3">
                <p class="card-title ml-n1">Pemesanan History</p>
                </div>
                <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="solid-header">
                            <th colspan="2" class="pl-4">Pemesan</th>
                            <th>No Pemesanan</th>
                            <th>Purchased On</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    
                    foreach ($data_pemesanan_lunas as $p) {
                    ?>
                        <tr>
                            <td class="pr-0 pl-4">
                                <img class="profile-img img-sm" src="../assets/images/profile/male/image_4.png" alt="profile image">
                            </td>
                            <td class="pl-md-0">
                            <small class="text-black font-weight-medium d-block"><?= $p['nama'] ?></small>
                            <span class="text-gray">
                                <span class="status-indicator rounded-indicator small bg-primary"></span><?= $p['no_hp'] ?> </span>
                            </td>
                            <td>
                            <small><?= invoice_code."".$p['id'] ?></small>
                            </td>
                            <td> <?= App::date($p['tanggal_pemesanan']) ?> </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                </div>
                <a class="border-top px-3 py-2 d-block text-gray" href="<?= BASEADM."pemesanan" ?>">
                    <small class="font-weight-medium"><i class="mdi mdi-chevron-down mr-2"></i>View All Order History</small>
                </a>
            </div>
        </div>
        <!-- <div class="col-md-4 equel-grid">
            <div class="grid">
                <div class="grid-body">
                <div class="split-header">
                    <p class="card-title">Activity Log</p>
                    <div class="btn-group">
                    <button type="button" class="btn btn-trasnparent action-btn btn-xs component-flat pr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Expand View</a>
                        <a class="dropdown-item" href="#">Edit</a>
                    </div>
                    </div>
                </div>
                <div class="vertical-timeline-wrapper">
                    <div class="timeline-vertical dashboard-timeline">
                    <div class="activity-log">
                        <p class="log-name">Agnes Holt</p>
                        <div class="log-details">Analytics dashboard has been created<span class="text-primary ml-1">#Slack</span></div>
                        <small class="log-time">8 mins Ago</small>
                    </div>
                    <div class="activity-log">
                        <p class="log-name">Ronald Edwards</p>
                        <div class="log-details">Report has been updated <div class="grouped-images mt-2">
                            <img class="img-sm" src="../assets/images/profile/male/image_4.png" alt="Profile Image" data-toggle="tooltip" title="Gerald Pierce">
                            <img class="img-sm" src="../assets/images/profile/male/image_5.png" alt="Profile Image" data-toggle="tooltip" title="Edward Wilson">
                            <img class="img-sm" src="../assets/images/profile/female/image_6.png" alt="Profile Image" data-toggle="tooltip" title="Billy Williams">
                            <img class="img-sm" src="../assets/images/profile/male/image_6.png" alt="Profile Image" data-toggle="tooltip" title="Lelia Hampton">
                            <span class="plus-text img-sm">+3</span>
                        </div>
                        </div>
                        <small class="log-time">3 Hours Ago</small>
                    </div>
                    <div class="activity-log">
                        <p class="log-name">Charlie Newton</p>
                        <div class="log-details"> Approved your request <div class="wrapper mt-2">
                            <button type="button" class="btn btn-xs btn-primary">Approve</button>
                            <button type="button" class="btn btn-xs btn-inverse-primary">Reject</button>
                        </div>
                        </div>
                        <small class="log-time">2 Hours Ago</small>
                    </div>
                    <div class="activity-log">
                        <p class="log-name">Gussie Page</p>
                        <div class="log-details">Added new task: Slack home page</div>
                        <small class="log-time">4 Hours Ago</small>
                    </div>
                    <div class="activity-log">
                        <p class="log-name">Ina Mendoza</p>
                        <div class="log-details">Added new images</div>
                        <small class="log-time">8 Hours Ago</small>
                    </div>
                    </div>
                </div>
                </div>
                <a class="border-top px-3 py-2 d-block text-gray" href="#">
                <small class="font-weight-medium"><i class="mdi mdi-chevron-down mr-2"></i> View All </small>
                </a>
            </div>
        </div> -->
    </div>
    </div>
</div>
<script>
    var jumlah_pemesanan = '<?= $jumlah_pemesanan ?>';
    var bulan_pemesanan = '<?= $bulan_pemesanan ?>';
    var presentase_pemesanan = '<?= $presentase_pemesanan ?>';
    var pesanan = <?= $label_pesanan ?>;
    var data_pesanan = <?= $data_pesanan ?>;
</script>
<!-- page content ends -->