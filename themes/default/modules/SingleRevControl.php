<script type="text/javascript">
		function revNav(action){
			var maxRev = <?php echo getLastRev() ?>;
			var minRev = 1;
			var revInput = '.rev_input';
			var currentRev = $(revInput).val();
			if(!currentRev){
				currentRev = maxRev;
			}
			if (action=="+") {
				newRev = (parseInt(currentRev,10)+1);
			}
			if(action=="-") {
				newRev = (parseInt(currentRev,10)-1);
			}
			if(action=="max") {
				newRev = maxRev;
			}

			if(newRev>maxRev){
				newRev = maxRev;
			}
			if(newRev<minRev){
				newRev = minRev;
			}

			$(revInput).val( newRev );
		}
	$( document ).ready(function() {

	});
</script>
<div class="panel panel-default">
	<div class="panel-heading"><?php echo t('revision') ?></div>
	<div class="panel-body">
		<form class="form-inline pull-right" role="form" method="GET" action="">
			<?php
			foreach (getGET(array('rev')) as $key => $value) {
				echo "<input type='hidden' name='".$key."' value='".$value."'>";
			}
			?>
			<div class="col-lg-12">
				<div class="form-group">
					<div class="input-group text-center">
					    <span class="input-group-btn">
					    	<button class="btn btn-default btn-sm <?php if(1==getRev(true)){echo 'disabled';} ?>" onclick="revNav('-')" type="submit"><span class="glyphicon glyphicon-chevron-left"></span></button>
					    </span>
						<input type="text" class="form-control input-sm rev_input" name="rev" value="<?php echo getRev(true) ?>" placeholder="HEAD">
					    <span class="input-group-btn">
					    	<button class="btn btn-default btn-sm" type="submit"><span class="glyphicon glyphicon-screenshot"></span></button>
					    	<button class="btn btn-default btn-sm <?php if(getLastRev()==getRev(true) OR 'HEAD'==getRev()){echo 'disabled';} ?>" onclick="revNav('max')" type="submit" default><span class="glyphicon glyphicon-step-forward"></span></button>
					    	<button class="btn btn-default btn-sm <?php if(getLastRev()==getRev(true) OR 'HEAD'==getRev()){echo 'disabled';} ?>" onclick="revNav('+')" type="submit"><span class="glyphicon glyphicon-chevron-right"></span></button>
					    </span>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
