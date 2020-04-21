<?php
if(isset($_SESSION['alert'])) {
    echo "<div class='alert alert-".$_SESSION['alert'][0]."'><b>Alert</b>: ".$_SESSION['alert'][1]."</div>";
    unset($_SESSION['alert']);
}