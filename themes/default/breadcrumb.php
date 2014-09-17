<div class="col-md-10">
	<ol class="breadcrumb">
		<li class="dropdown">

		    <a href="<?php echo getUrl('repo', '', true) ?>"><?php echo t('root') ?></a>
		    <a class="dropdown-toggle" role="button" data-toggle="dropdown" >
		    	<b class="caret"></b>
		    </a>

		    <ul id="branches-dropdown" class="dropdown-menu">
		    	<li role="presentation"><a href="<?php echo getUrl('repo', '', true) ?>"><span class="glyphicon glyphicon-folder-open"></span> <code><?php echo t('root') ?></code></a></li>
				<li role="presentation" class="divider"></li>
		        <li role="presentation"><a tabindex="-1" href="<?php echo getUrl('diff', '', true) ?>"><span class="glyphicon glyphicon-transfer"></span> <?php echo t('diff') ?></a></li>
		        <li role="presentation"><a tabindex="-1" href="<?php echo getUrl('log', '', true) ?>"><span class="glyphicon glyphicon-th-list"></span> <?php echo t('log') ?></a></li>
		        <li role="presentation"><a tabindex="-1" href="<?php echo getUrl('download', '', true) ?>"><span class="glyphicon glyphicon-cloud-download"></span> <?php echo t('download') ?></a></li>
		    </ul>
		</li>
			<?php
			$path = array();
			$chunks = explode('/', rtrim(getPath(), "/"));
			foreach ($chunks as $i => $chunk) {
				$path[] = $chunk;
				$path_txt = implode("/", $path);
				if((count($chunks)-1) == $i){
					?>
					<li class="active"><?php echo $chunk ?></li>
					<?php
				}else{
					?>
					<li class="dropdown">

					    <a href="<?php echo getUrl('repo', $path_txt."/", true) ?>"><?php echo $chunk ?></a>
					    <a class="dropdown-toggle" role="button" data-toggle="dropdown" >
					    	<b class="caret"></b>
					    </a>

					    <ul class="dropdown-menu">
					    	<li role="presentation"><a href="<?php echo getUrl(getPage(), '', true) ?>"><span class="glyphicon glyphicon-folder-open"></span> <code><?php echo $chunk ?></code></a></li>
							<li role="presentation" class="divider"></li>
					        <li role="presentation"><a tabindex="-1" href="<?php echo getUrl('diff', $path_txt."/", true) ?>"><span class="glyphicon glyphicon-transfer"></span> <?php echo t('diff') ?></a></li>
					        <li role="presentation"><a tabindex="-1" href="<?php echo getUrl('log', $path_txt."/", true) ?>"><span class="glyphicon glyphicon-th-list"></span> <?php echo t('log') ?></code></a></li>
					        <li role="presentation"><a tabindex="-1" href="<?php echo getUrl('download', $path_txt."/", true) ?>"><span class="glyphicon glyphicon-cloud-download"></span> <?php echo t('download') ?></code></a></li>
					    </ul>
					</li>

					<?php
				}
			}
			?>

	</ol>
</div>

<div class="col-md-2 text-center">
	<ol class="breadcrumb" style="padding: 8px 10px;">
		<?php
		if(getPage()=="file"){
			?>
				<a class="btn btn-default btn-xs" rel="tooltip" title="<?php echo t('raw') ?>" target="_blank" onclick="windowpop(this.href, 545, 433); return false;" href="<?php echo getUrl('raw', getPath(), true) ?>">
					<span class="fa fa-code"></span>
				</a>
				<span class="btn btn-default btn-xs btnCopy" rel="tooltip" title="<?php echo t('copy') ?>" >
					<span class="fa fa-copy"></span>
				</span>
			<?php
		}
		?>
		<a class="btn btn-default btn-xs" href="<?php echo getUrl('diff', getPath(), true) ?>" rel="tooltip" title="<?php echo t('diff') ?>">
			<span class="glyphicon glyphicon-transfer"></span>
		</a>
		<a class="btn btn-default btn-xs" href="<?php echo getUrl('log', getPath(), true) ?>" rel="tooltip" title="<?php echo t('log') ?>">
			<span class="glyphicon glyphicon-th-list"></span>
		</a>
		<a class="btn btn-default btn-xs" href="<?php echo getUrl('download', getPath(), true) ?>" rel="tooltip" title="<?php echo t('download') ?>">
			<span class="glyphicon glyphicon-cloud-download"></span>
		</a>
	</ol>
</div>

<?php
/* 		<a href="?page=repo&repo=<?php echo getRepo(); ?>&path=<?php echo dirname(getPath()); ?>/"><?php echo dirname(getPath()) ?>/</a>
*/
?>
