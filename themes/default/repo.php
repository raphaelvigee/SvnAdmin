<?php
include 'header-title.php';

//$files = getSeparatedDirList(getRepo()."/".getPath());
$files = getOrderedDirList();

// echo '<pre>';
// print_r($files);
// echo '</pre>';

?>
	<div class="row">
	<?php
	include 'breadcrumb.php';

?>
<div class="col-lg-3 col-sm-5">
	<?php
	include 'modules/SingleRevControl.php';
	include 'modules/date.php';
	include 'modules/author.php';
	include 'modules/msg.php';
	include 'modules/goToTop.php';
	?>
</div>
	<div class="col-lg-9 col-sm-7">
	<?php
	if(!empty(array_filter($files))){
		?>
		<table class="table table-hover">
		<thead>
			<tr>
				<th><?php echo t('fichiers') ?></th>
				<th><?php echo t('size') ?></th>
				<th><?php echo t('actions') ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach ($files as $key => $value) {
				?>
				<tr>
					<?php
					if($value['attrib']['kind']=="dir"){
						?>
						<td><span class="fa fa-folder"></span> <a href="<?php echo getUrl('repo', $value['name'].'/') ?>"><?php echo $value['name'] ?></a></td>
						<td></td>
						<td>
							<a class="btn btn-default btn-xs" href="<?php echo getUrl('diff', $value['name']) ?>">
								<span class="glyphicon glyphicon-transfer"></span> <span class="hidden-xs hidden-sm"><?php echo t('diff') ?></span> 
							</a>
							<a class="btn btn-default btn-xs" href="<?php echo getUrl('log', $value['name']) ?>">
								<span class="glyphicon glyphicon-th-list"></span> <span class="hidden-xs hidden-sm"><?php echo t('log') ?></span> 
							</a>
							<a class="btn btn-default btn-xs" href="<?php echo getUrl('download', $value['name']) ?>">
								<span class="glyphicon glyphicon-cloud-download"></span> <span class="hidden-xs hidden-sm"><?php echo t('download') ?></span> 
							</a>
						</td>
						<?php
					}else{
						?>
						<td><span class="fa fa-file-text"></span> <a href="<?php echo getUrl('file', $value['name']) ?>"><?php echo $value['name'] ?></a></td>
						<td><?php echo getHumanSize($value['size']) ?></td>
						<td>
							<a class="btn btn-default btn-xs" href="<?php echo getUrl('diff', $value['name']) ?>">
								<span class="glyphicon glyphicon-transfer"></span> <span class="hidden-xs hidden-sm"><?php echo t('diff') ?></span> 
							</a>
							<a class="btn btn-default btn-xs" href="<?php echo getUrl('log', $value['name']) ?>">
								<span class="glyphicon glyphicon-th-list"></span> <span class="hidden-xs hidden-sm"><?php echo t('log') ?></span> 
							</a>
							<a class="btn btn-default btn-xs" href="<?php echo getUrl('download', $value['name']) ?>">
								<span class="glyphicon glyphicon-cloud-download"></span> <span class="hidden-xs hidden-sm"><?php echo t('download') ?></span> 
							</a>
							<a class="btn btn-default btn-xs" target="_blank" onclick="windowpop(this.href, 545, 433); return false;" href="<?php echo getUrl('raw', $value['name']) ?>">
								<span class="fa fa-code"></span> <span class="hidden-xs hidden-sm"><?php echo t('raw') ?></span> 
							</a>
						</td>
						<?php
					}
					?>
					<?php
					?>
				</tr>
				<?php
			}
		?>
		</tbody>
		</table>
		<?php
	}else{
		?>
			<div class="alert alert-warning" role="alert"><?php echo t('folderEmpty',array(getPath())) ?></div>

		<?php
	}
	?>	
	</div>

<?php
?>