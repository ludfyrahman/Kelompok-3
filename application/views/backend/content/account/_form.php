<div class="title">
    <?php echo $title ?>
</div>

<div id="page-wrapper" data-type="account">
    <form action="" method="post">
        <?php Response::part('alert') ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" placeholder="Name..." class="form-control" id="name" value="<?php echo Input::postOrOr('name', $data['name']) ?>" name="name" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" placeholder="Email..." class="form-control" id="email" value="<?php echo Input::postOrOr('email', $data['email']) ?>" name="email" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Password..." class="form-control" id="password"  name="password" <?php echo $type == 'Tambah' ? 'required' : '' ?>>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="level">Level</label>
                    <?php $n = Input::postOrOr('level', $data['level']) ?>
                    <select name="level" id="level" class="form-control" required>
                        <option>- Select -</option>
                        <option value="1" <?php echo ($n == '1' ? 'selected' : '') ?>>Admin</option>
                        <option value="2" <?php echo ($n == '2' ? 'selected' : '') ?>>Member</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="clear">
            <div class="pull-right">
                <input type="reset" class="btn btn-blue" value="Ulangi">
                <input type="submit" class="btn btn-blue" value="<?php echo $type ?>">
            </div>
        </div>
    </form>
</div>