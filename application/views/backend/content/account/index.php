<div class="title">
    <?php echo $title ?>
</div>

<div id="page-wrapper" data-type="account">
    <?php Response_Helper::part('alert'); $level = [1 => 'Admin', 'Member'] ?>
    <div class="section-table">
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Level</th>
            </tr>
            <?php
            foreach($lists as $l) {
                echo "<tr>
                <td>$l[name]<span><a href='".BASEADM."account/$l[id]/edit'>Edit</a> | <a href='".BASEADM."account/$l[id]/delete'>Delete</a></span></td>
                <td>$l[email]</td>
                <td>".$level[$l['level']]."</td>
            </tr>";
            }
            ?>
        </table>
    </div>
</div>