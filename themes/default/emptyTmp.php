<?php
$empty = emptyTmp();

if($empty==0){
    ?>

    <form role="form">
        <p><?php echo t('emptyTmpSure') ?></p>
        <a href="?page=emptytmp&sure=1">Continuer</a>
    </form>

    <?php
}elseif($empty==1){
    ?>
    <div class="alert alert-success" role="alert"><?php echo t('emptyTmpSuccess') ?></div>
    <?php
}elseif($empty==-1){
    ?>
    <div class="alert alert-danger" role="alert"><?php echo t('writeError',array(get('TmpPath')) ) ?></div>
    <?php
}
?>