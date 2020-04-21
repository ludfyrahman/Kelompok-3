<div class="title">
    <?php echo $title ?>
</div>

<div id="page-wrapper">
    <form action="" method="post">
        <?php Response::part('alert') ?>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="form-group">
                    <label for="old_password">Password Lama</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password..." required>
                </div>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password..." required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation..." required>
                </div>
            </div>
        </div>

        <div class="clear">
            <div class="pull-right">
                <input type="submit" class="btn btn-blue" value="Ubah">
            </div>
        </div>
    </form>
</div>