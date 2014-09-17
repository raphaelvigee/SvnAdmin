<?php
include 'header-title.php'
?>
	<div class="row">
<?php

include 'breadcrumb.php';
?>
	<div class="col-md-12">
	<?php
		$dlUid = download();
	?>
	<div class="jumbotron text-center">
		<h2><?php echo t('downloadRunning') ?></h2>
		<small><?php echo t('ifDownloadDontStart',array('./tmp/'.$dlUid.'.zip')) ?></small>
		<br>
		<br>
		<div class="progress">
			<div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				<span class="sr-only"><?php echo t('downloadRunning') ?></span>
			</div>
		</div>
	</div>
	<meta http-equiv="refresh" content="1; url=<?php echo './tmp/'.$dlUid.'.zip' ?>" />
	</div>
	<?php
			
			/*<div class="alert alert-error" role="alert">Le fichier <strong><?php echo getRepoPath().getPath() ?></strong> n'éxiste pas.</div>
			*/
	?>


