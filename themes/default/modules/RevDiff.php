<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					<?php echo t('revSource') ?>
				</a>
			</h4>
		</div>
		<div id="collapseOne" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo t('date') ?></div>
					<div class="panel-body">
						<?php echo getCommitDate(null,true); ?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo t('message') ?></div>
					<div class="panel-body">
						<?php echo getCommitMsg(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
					<?php echo t('revDest') ?>
				</a>
			</h4>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse out">
			<div class="panel-body">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo t('date') ?></div>
					<div class="panel-body">
						<?php echo getCommitDate(2,true); ?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo t('message') ?></div>
					<div class="panel-body">
						<?php echo getCommitMsg(2); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>