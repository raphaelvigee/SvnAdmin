<?php
include 'header-title.php'
?>
	<div class="row">
<?php
$log = getLogDiff();

// echo '<pre>';
// print_r($log);
// echo '</pre>';

include 'breadcrumb.php';

$page = getPageNb();

$offset=($page-1)*getMax(); // On calcul la première entrée à lire

?>
		<?php
		/*<pre class="prettyprint linenums"><?php echo trim(htmlspecialchars($diff)); ?></pre>*/

?>
	<div class="col-md-3">


<?php
include 'modules/LogRevControl.php';
include 'modules/RevDiff.php';
include 'modules/goToTop.php';
?>

	</div>
	
	<div class="col-md-9">
	<?php
if(!empty($log)){

	?>
	<div class="table-responsive">
		<table class="table table-hover table-condensed">
		<thead>
			<tr>
				<th><?php echo t('revision') ?></th>
				<th><?php echo t('author') ?></th>
				<th><?php echo t('date') ?></th>
				<th><?php echo t('state') ?></th>
				<th><?php echo t('type') ?></th>
				<th><?php echo t('path') ?></th>
			</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
					foreach (array_slice($log, $offset, getMax()) as $key => $value) {
						?>
							<tr>
								<td rowspan="<?php echo count($value['paths']['path']) ?>"><?php echo $value['attrib']['revision'] ?></td>
								<td rowspan="<?php echo count($value['paths']['path']) ?>"><?php echo $value['author'] ?></td>
								<td rowspan="<?php echo count($value['paths']['path']) ?>"><?php echo getHumanDate($value['date']) ?></td>
						<?php
						$i2=1;
							foreach ($value['paths']['path'] as $key2 => $value2) {
								?>
									<?php
									if($i2!=1){
										?>
										<tr>
										<?php
									}

									switch (trim($value2['attrib']['action'])) {																				
										case 'M':
											?>
												<td><span class="label label-warning">M</span></td>
											<?php
											break;
										
										case 'A':
											?>
												<td><span class="label label-success">A</span></td>
											<?php
											break;
										
										case 'D':
											?>
												<td><span class="label label-danger">D</span></td>
											<?php
											break;
										
										default:
											?>
												<td><span class="label label-default">U</span></td>
											<?php
											break;
									}
									?>
										<?php
										if($value2['attrib']['kind']=="file"){
										?>
											<td><span class="fa fa-file-text"></span></td>
											<td class="path"><a href="<?php echo getUrl('file', trim($value2['cdata'],'/'),true, array('rev'=>$value['attrib']['revision'])) ?>"><?php echo htmlspecialchars($value2['cdata']) ?></a></td>
										<?php
										}elseif($value2['attrib']['kind']=="dir"){
										?>
											<td><span class="fa fa-folder"></span></td>
											<td class="path"><a href="<?php echo getUrl('repo', trim($value2['cdata'],'/').'/',true, array('rev'=>$value['attrib']['revision'])) ?>"><?php echo htmlspecialchars($value2['cdata']) ?></a></td>
										<?php
										}else{
										?>
											<td><span class="glyphicon glyphicon glyphicon-question-sign"></span></td>
											<td class="path"><a href="<?php echo getUrl('repo', trim($value2['cdata'],'/').'/',true, array('rev'=>$value['attrib']['revision'])) ?>"><?php echo htmlspecialchars($value2['cdata']) ?></a></td>
										<?php
										}
										?>
									</tr>
								<?php
								$i2++;
							}
							?>
							<?php
						if ($i++ == getMax()) break;
					}
				?>
				</tbody>
		</table>
		</div>

		<?php 
		$nbPage = ceil(count($log)/getMax());

		if($nbPage>1){
			?>
			<ul class="pagination">
				<li><a href="<?php echo getUrl("null", getPath(),true, array('pagenb'=> 1,'max'=>getMax(),'mode'=>$_GET['mode'] )) ?>">&laquo;</a></li>

			<?php 

			$siblingsNbr = 4;


			for ($i=1; $i < ($nbPage+1); $i++) { 
				if( $i >= (getPageNb()-$siblingsNbr) AND $i <= (getPageNb()+$siblingsNbr) ){
					if((getPageNb()-$siblingsNbr)==$i){
						?>
							<li ><a>...</a></li>
						<?php
					}
					?>
					<li <?php if($i==getPageNb()){ echo 'class="active"'; } ?>><a href="<?php echo getUrl(getPage(), getPath(),true, array('pagenb'=> $i,'max'=>getMax(),'mode'=>$_GET['mode'] )) ?>"><?php echo $i; ?></a></li>
					<?php
					if((getPageNb()+$siblingsNbr)==$i){
						?>
							<li ><a>...</a></li>
						<?php
					}
				}
			}
			?>


				<li><a href="<?php echo getUrl("null", getPath(),true, array('pagenb'=> $nbPage,'max'=>getMax(),'mode'=>$_GET['mode'] )) ?>">&raquo;</a></li>
			</ul>

			<?php 
		}
		}else{ ?> 
			<div class="alert alert-warning" role="alert"><?php echo t('noLog',array(getPath(),getRev(),getRev2())) ?></div>
		<?php }?>
	</div>
	<style type="text/css">
		.table td.path {
		  white-space: nowrap;
		  overflow: hidden;
		  text-overflow: ellipsis;
		}

		.table-responsive {
			overflow-x: auto;
		}
	</style>
	<?php

			
			/*<div class="alert alert-error" role="alert">Le fichier <strong><?php echo getRepoPath().getPath() ?></strong> n'éxiste pas.</div>
			*/
	?>


