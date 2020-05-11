<div class="viewport-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb has-arrow">
        <li class="breadcrumb-item">
            <a href="<?=BASEADM."dashboard"?>">Dashboard</a>
        </li>
        <?php
            for($i = 3; $i < count(Response_Helper::url());$i++){
        ?>
            <li class="breadcrumb-item <?= (count(Response_Helper::url()) - 1 == $i ? 'active' : '') ?>" aria-current="page">
                <?php 
                    if((count(Response_Helper::url()) - 1) != $i){
                ?>
                <a href="<?=BASEADM.Response_Helper::uri(3)?>">
                    <?=Response_Helper::url()[$i]?>
                </a>
                <?php }else{?>
                    <?=Response_Helper::url()[$i]?>
                <?php } ?>
            </li>
        <?php } ?>
        </ol>
    </nav>
</div>