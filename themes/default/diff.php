<?php
include 'header-title.php'
?>
	<div class="row">
<?php
$diff = getDiff(getPath(),getRev(),getRev2());

include 'breadcrumb.php';
?>
	<?php
		/*<pre class="prettyprint linenums"><?php echo trim(htmlspecialchars($diff)); ?></pre>*/

?>
	<div class="col-md-3">

<?php
include 'modules/SingleDiffControl.php';
include 'modules/RevDiff.php';
include 'modules/goToTop.php';
?>

	</div>

	<div class="col-md-9">
		<?php
		if(!empty($diff)){
		?>
			<ul class="list-group">
				<?php
				foreach ($diff as $key => $value) {
						 if(substr($value, 0, 1)=="-"){
						 	?>
							<li class="list-group-item list-group-item-danger"><?php echo htmlspecialchars(substr($value, 1)); ?></li>
						 	<?php
					}elseif(substr($value, 0, 1)=="+"){
						 	?>
							<li class="list-group-item list-group-item-success"><?php echo htmlspecialchars(substr($value, 1)); ?></li>
						 	<?php
					}elseif(substr($value, 0, 2)==("@@")){
						 	?>
							<li class="list-group-item list-group-item-info"><?php echo htmlspecialchars($value); ?></li>
						 	<?php
					}elseif(substr(trim($value), 0, 7)=="Index: "){
						 	?>
						 	</ul>
						 	<ul class="list-group">
							<li class="list-group-item list-group-item-warning"><?php echo htmlspecialchars($value); ?></li>
						 	<?php
					}else{
						 	?>
							<li class="list-group-item"><?php echo htmlspecialchars($value); ?></li>
						 	<?php
					}
				}
				?>
			</ul>
		<?php
		}else{
		?>
			<div class="alert alert-warning" role="alert"><?php echo t('noDiff',array(getPath(),getRev(),getRev2())) ?></div>
		<?php
		}
		?>
	</div>
	<style type="text/css">
	.list-group .list-group-item{
		padding: 5px 7px;
		min-height: 32px;
		overflow-wrap: break-word;
	}
	</style>
	<?php
			
			/*<div class="alert alert-error" role="alert">Le fichier <strong><?php echo getRepoPath().getPath() ?></strong> n'éxiste pas.</div>
			*/
	?>


