<div class="panel panel-default">
	<script type="text/javascript">
		$(document).ready(function(){
			$(".rev").keyup(function(){ 
				var mode = $('.modeChoice:checked').val();
				if(mode=='log'){
					$('.rev2').val($('.rev').val());
				}			
			});		
			$(".modeChoice").change(function() {
				changeMode();
			});
			changeMode();
		});

		function changeMode(){
			var mode = $('.modeChoice:checked').val();
			console.log(mode);
			if(mode=='log'){
				$('.rev2').attr('readonly','readonly');
				$('.rev2').val($('.rev').val());
				$('.rev2').attr("value",$('.rev').val());
			}else{
				$(".rev2").removeAttr('readonly');
			}
		}
	</script>

	<div class="panel-heading"><?php echo t('log') ?></div>
	<div class="panel-body">

		<form class="" role="form" method="GET" action="">
			<?php
			foreach (getGET(array('rev','rev2','max','mode')) as $key => $value) {
				echo "<input type='hidden' name='".$key."' value='".$value."'>";
			}
			?>
			<div class="form-group text-center">
				<div class="btn-group btn-group-justified" data-toggle="buttons">
					<label class="btn btn-default btn-md col-md-6  <?php if($_GET['mode']=="log" OR $_GET['mode']==null){ echo "active"; } ?>">
						<input class="modeChoice" type="radio" name="mode" value="log" id="log" <?php if(@$_GET['mode']=="log" OR @$_GET['mode']==null){ echo "checked"; } ?> > <?php echo t('byRev') ?>
					</label>
					<label class="btn btn-default btn-md col-md-6 <?php if($_GET['mode']=="difflog"){ echo "active"; } ?>">
						<input class="modeChoice" type="radio" name="mode" value="difflog" id="difflog" <?php if(@$_GET['mode']=="difflog"){ echo "checked"; } ?> > <?php echo t('byInt') ?>
					</label>
				</div>
			</div>
			<div class="form-group btn-group-justified">
				<div class="input-group" rel="tooltip" title="<?php echo t('letEmptyForUnlimited') ?>">

					<span class="input-group-addon"><?php echo t('maxLines') ?>:</span>
					<input type="text" class="form-control input-sm" name="max" value="<?php echo getMax() ?>">
				</div>
			</div>
			<div class="form-group btn-group-justified">
				<div class="input-group">
					<input type="text" class="form-control input-sm rev" name="rev" value="<?php echo getRev(true) ?>" placeholder="HEAD">
					<span class="input-group-addon">:</span>
					<input type="text" class="form-control input-sm rev2" name="rev2" value="<?php echo getRev2(true) ?>" placeholder="HEAD">
				    <span class="input-group-btn">
				    	<button class="btn btn-default btn-sm" type="submit"><span class="glyphicon glyphicon-arrow-right"></span></button>
				    </span>
				</div>
			</div>
		</form>

	</div>
</div>