<?php
$config_txt = "";

foreach (getFullReposConfig()[getRepoSlug()] as $key => $value) {
	$config_txt .= "<div class='row'><div class='col-md-6'><strong>".$key."</strong>:</div> <div class='col-md-6'>".$value.'</div></div>';
}
?>
<div class="page-header">
	<h1>
	<span class="text-uppercase"><?php echo t('repo') ?> <?php echo getRepoSlug(); ?></span> 
	<small style="font-size:20px;" class="visible-sm-inline visible-md-inline visible-lg-inline"><span class="glyphicon glyphicon-cog" rel="popover" title="Config" data-container="body" data-content="<?php echo $config_txt; ?>"></span></small> 
	<small><?php echo t('revision') ?> <?php echo getLastRev(); ?></small>
	</h1>
</div>