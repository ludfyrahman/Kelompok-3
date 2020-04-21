<div class="title">
    <?php echo $title ?>
</div>

<div id="page-wrapper">
    <form action="" method="post">
        <?php Response::part('alert') ?>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama..." value="<?php echo Input::postOrOr('name', Account_Helper::Get('name')) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email..." value="<?php echo Input::postOrOr('email', Account_Helper::Get('email')) ?>" required>
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