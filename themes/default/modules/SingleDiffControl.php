<div class="panel panel-default">
	<div class="panel-heading"><?php echo t('diff') ?></div>
	<div class="panel-body">
		<form class="form-inline" role="form" method="GET" action="">
			<?php
			foreach (getGET(array('rev','rev2')) as $key => $value) {
				echo "<input type='hidden' name='".$key."' value='".$value."'>";
			}
			?>
			<div class="form-group">
				<div class="input-group text-center">
					<input type="text" class="form-control input-sm" name="rev" value="<?php echo getRev(true) ?>" placeholder="HEAD">
					<span class="input-group-addon">:</span>
					<input type="text" class="form-control input-sm" name="rev2" value="<?php echo getRev2(true) ?>" placeholder="HEAD">
				    <span class="input-group-btn">
				    	<button class="btn btn-default btn-sm" type="submit"><?php echo t('diff') ?></button>
				    </span>
				</div>
			</div>
		</form>
	</div>
</div>
