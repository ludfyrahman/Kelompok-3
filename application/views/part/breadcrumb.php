<div class="viewport-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb has-arrow">
        <li class="breadcrumb-item">
            <a href="<?=BASEADM."dashboard"?>">Dashboard</a>
        </li>
        <?php
            for($i = 3; $i < count(App::url());$i++){
        ?>
            <li class="breadcrumb-item <?= (count(App::url()) - 1 == $i ? 'active' : '') ?>" aria-current="page">
                <?php 
                    if((count(App::url()) - 1) != $i){
                ?>
                <a href="<?=BASEADM.App::uri(3)?>">
                    <?=App::url()[$i]?>
                </a>
                <?php }else{?>
                    <?=App::url()[$i]?>
                <?php } ?>
            </li>
        <?php } ?>
        </ol>
    </nav>
</div>