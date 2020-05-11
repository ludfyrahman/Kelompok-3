<!-- ***** Blog Area Start ***** -->
<section id="blog" class="section blog-area ptb_100">
    <div class="container">
        <div class="row">
            <?php
            Response_Helper::part('sidebar_profile');
            ?>
            <div class="col-12 col-lg-9">
                <!-- Single Blog Details -->
                <article class="single-blog-details ">
                <?php Response_Helper::part('alert'); ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="" >
                                <div>
                                    <img src="<?= BASEASSET."images/upload/profil/".Account_Helper::get("profil") ?>" alt="" id="profile" class="img-fluid" style="width:100%">
                                    <input type="file" id="foto" name="foto" style="display:none;" />
                                </div>
                                <div class="card-body">
                                    <a href="#"class="btn btn-block btn-sm" data-toggle="modal" data-target="#ubah_password">Ubah Kata Sandi</a>
                                    <a href="#" class="btn btn-block btn-sm" onclick="thisFileUpload();">Pilih Foto</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="margin-top-bottom-12">Biodata Diri <a href="#" class="color-primary"  data-toggle="modal" data-target="#akun">Ubah</a></h5> 
                            <div class="margin-top-bottom-12">
                                <label for="" class='col-4'>Nama</label>
                                <span class="col-d"><?= Account_Helper::Get("nama") ?></span>
                            </div>
                            <div class="margin-top-bottom-12">
                                <label for="" class='col-4'>Tanggal Lahir</label>
                                <span class="col-d"><?= Response_Helper::Date(Account_Helper::Get("tanggal_lahir"), 'd M Y') ?></span>
                            </div>
                            <div class="margin-top-bottom-12">
                                <label for="" class='col-4'>Jenis Kelamin</label>
                                <span class="col-d"><?= jenis_kelamin[Account_Helper::Get("jenis_kelamin")] ?></span>
                            </div>
                            <h5 class="margin-top-bottom-12">Ubah Kontak</h5>
                            <div class="margin-top-bottom-12">
                                <label for="" class='col-4'>No Hp</label>
                                <span class="col-4"><?= Account_Helper::Get("no_hp") ?></span>
                                <span class="badge <?= (Account_Helper::get("stnohp") == 1 ? 'badge-success' : 'badge-warning') ?>"><i class="fa fa-check"></i> <?= (Account_Helper::get("stnohp") == 1 ? 'Terverifikasi' : 'tidak Terverifikasi') ?></span>
                                <a href="#" class="color-primary"  data-toggle="modal" data-target="#no_hp">Ubah</a>
                            </div>
                            <div class="margin-top-bottom-12">
                                <label for="" class='col-4'>Email</label>
                                <span class="col-4"><?= Account_Helper::Get("email") ?></span>
                                <span class="badge <?= (Account_Helper::get("stemail") == 1 ? 'badge-success' : 'badge-warning') ?>"><i class="fa fa-check"></i> <?= (Account_Helper::get("stemail") == 1 ? 'Terverifikasi' : 'tidak Terverifikasi') ?></span>
                                <a href="#" class="color-primary" data-toggle="modal" data-target="#email">Ubah</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<!-- modal -->

<!-- ubah password -->
<div class="modal fade" id="ubah_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah Kata Sandi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= BASEURL."pengguna/profil/proses_password" ?>" method="POST" >
        <div class="modal-body">
            <div class="form-group">
                <label for="">Kata Sandi Lama</label>
                <input type="password" name="old_password" class="form-control" placeholder="masukkan kata sandi lama anda" required>
            </div>
            <div class="form-group">
                <label for="">Kata Sandi Baru</label>
                <input type="password" name="new_password" class="form-control" placeholder="masukkan kata sandi baru anda" required>
            </div>
            <div class="form-group">
                <label for="">Ulangi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="ulangi kata sandi baru anda" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- verifikasi email -->
<div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <a href="#">
                <div class="single-blog wow fadeIn res-margin" data-wow-duration="2s">
                    <div class="blog-content p-4" id="verifikasi_email">
                        <i class="fa fa-envelope text-success"></i>  <?= Account_Helper::get('email') ?>
                    </div>
                </div>
            </a>
        </div>
    </div>
  </div>
</div>
<div class="modal fade" id="code_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Masukkan Kode Verifikasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" >
      
        <div class="modal-body text-center">
            <p >Kode verifikasi yang telah dikirimkan ke email <?= Account_Helper::get("email") ?></p>
            <div class="form-group">
                <h3 for="" style="margin:20px">Kode verifikasi</h3>
                <input type="text" id="verification_email_code" class="form-control">
            </div>
            <p>Tidak menerima Kode ?</p>
            <a href="#">
              <p class="text-success" id="verifikasi_email">Kirim Ulang</p>
            </a>
            <button type="button" id="btn-proses-verifikasi-email" class="btn btn-success btn-block">Ubah</button>
        </div>
    </form>
    </div>
  </div>
</div>
<div class="modal fade" id="code_no_hp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Masukkan Kode Verifikasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST" >
      
        <div class="modal-body text-center">
            <p >Kode verifikasi yang telah dikirimkan ke No HP <?= Account_Helper::get("no_hp") ?></p>
            <div class="form-group">
                <h3 for="" style="margin:20px">Kode verifikasi</h3>
                <input type="text" id="verification_nohp_code" class="form-control">
            </div>
            <p>Tidak menerima Kode ?</p>
            <p class="text-success" id="verifikasi_no_hp">Kirim Ulang</p>
            <button type="button" id="btn-proses-verifikasi-nohp" class="btn btn-success btn-block">Ubah</button>
        </div>
    </form>
    </div>
  </div>
</div>
<!-- verifikasi no hp -->
<div class="modal fade" id="no_hp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi No HP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <a href="#" >
                <div class="single-blog wow fadeIn res-margin" data-wow-duration="2s">
                    <div class="blog-content p-4" id="verifikasi_no_hp">
                        <i class="fa fa-envelope text-success"></i>  <?= Account_Helper::get('no_hp') ?>
                    </div>
                </div>
            </a>
        </div>
    </div>
  </div>
</div>
<div class="modal fade " id="akun" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah Profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                  <a class="nav-link active" id="informasi-tab" data-toggle="tab" href="#diri" role="tab" aria-controls="diri" aria-selected="true"><i class="fa fa-clipboard-list"></i> Data Diri</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="ulasan-tab" data-toggle="tab" href="#rekening" role="tab" aria-controls="rekening" aria-selected="false"><i class="fa fa-swatchbook"></i>Data Rekening</a>
              </li>
          </ul>
          <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="diri" role="tabpanel" aria-labelledby="informasi-tab">
                  <div class="container">
                      <form action="#" method="POST" id="data_diri">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" placeholder="masukkan nama anda" class="form-control"  name="nama" value="<?= Input_Helper::postOrOr('nama', Account_Helper::Get("nama")) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" placeholder="masukkan email anda" class="form-control" name="email" value="<?= Input_Helper::postOrOr('email', Account_Helper::Get("email")) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">No Hp</label>
                            <input type="text" placeholder="masukkan no hp anda" class="form-control"  name="no_hp" value="<?= Input_Helper::postOrOr('no_hp', Account_Helper::Get("no_hp")) ?>" required>
                        </div>
                        <div class="form-group">
                            <?php 
                            $jen = Input_Helper::postOrOr('jenis_kelamin', Account_Helper::Get('jenis_kelamin'))
                            ?>
                            <label for="">Jenis Kelamin</label><br>
                            <input type="radio" value="1" name="jenis_kelamin" <?= ($jen == 1 ? 'checked' : '') ?>>Laki Laki
                            <input type="radio" value="2" name="jenis_kelamin" <?= ($jen == 2 ? 'checked' : '') ?>>Perempuan
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Lahir</label>
                            <input type="date" placeholder="masukkan Tanggal Lahir Anda" class="form-control" name="tanggal_lahir" value="<?= Input_Helper::postOrOr('tanggal_lahir', Account_Helper::Get("tanggal_lahir")) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat" class="form-control" id="" cols="30" rows="10" placeholder="masukkan alamat anda" required><?= Input_Helper::postOrOr('alamat', Account_Helper::Get("alamat")) ?></textarea>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-block" id="btn_simpan_data_diri" type="button">Simpan</button>
                        </div>
                      </form>
                  </div>
              </div>
              <div class="tab-pane fade" id="rekening" role="tabpanel" aria-labelledby="ulasan-tab">
                  <div class="container">
                      <form action="#" method="post">
                        <div class="form-group">
                            <label for="">Nama Bank</label>
                            <input type="text" placeholder="masukkan nama bank anda" class="form-control" name="nama_bank" value="<?= Input_Helper::postOrOr('nama_bank', Account_Helper::Get("nama_bank")) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Rekening</label>
                            <input type="text" placeholder="masukkan nama rekening anda" class="form-control" name="nama_rekening" value="<?= Input_Helper::postOrOr('nama_rekening', Account_Helper::Get("nama_rekening")) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">No Rekening</label>
                            <input type="text" placeholder="masukkan no rekening anda" class="form-control" name="no_rekening" value="<?= Input_Helper::postOrOr('no_rekening', Account_Helper::Get("no_rekening")) ?>" required>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-block" type="button" id="btn_simpan_data_rekening">Simpan</button>
                        </div>
                      </form>
                  </div>
              </div>
          </div>
        </div>
    </div>
  </div>
</div>
<!-- ***** Blog Area End ***** -->