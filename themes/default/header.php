<!DOCTYPE html>
<html>
<head>
	<title>Repos</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- Latest compiled and minified CSS -->


	<!-- Latest compiled and minified JavaScript -->

	<link href="<?php echo getThemeRoot() ?>/prettify/prettify.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo getThemeRoot() ?>/prettify/prettify.js"></script>


	<script type="text/javascript" src="<?php echo getThemeRoot() ?>/Bootstrap/js/bootstrap.min.js"></script>
	<link type="text/javascript" rel="stylesheet" href="<?php echo getThemeRoot() ?>/Bootstrap/css/bootstrap.min.css"></link>
	<link type="text/javascript" rel="stylesheet" href="<?php echo getThemeRoot() ?>/FontAwesome/css/font-awesome.min.css"></link>

	<style>
	*{
		outline: none;
	}
	li.L0, li.L1, li.L2, li.L3,
	li.L5, li.L6, li.L7, li.L8
	{ list-style-type: decimal !important }

	.scrollable-dropdown {
	    height: auto;
	    max-height: 500px;
	    overflow-x: hidden;
	}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
		  $('[rel="tooltip"]').tooltip(); 
		  $('[rel="popover"]').popover({ trigger: "hover",html:true });
		});

		function windowpop(url, width, height) {
			var leftPosition, topPosition;
			//Allow for borders.
			leftPosition = (window.screen.width / 2) - (((window.screen.width / 2) / 2) + 10);
			//Allow for title and status bars.
			topPosition = (window.screen.height / 2) - (((window.screen.height / 2) / 2) + 50);
			//Open the window.
			window.open(url, "Window2", "status=no,height=" + (window.screen.height / 2) + ",width=" + (window.screen.width / 2) + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
		}
	</script>
</head>
<body onload="prettyPrint()">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">SvnAdmin</a>
		      	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
		    </div>

		    <div class="container-fluid navbar-collapse collapse">
		    <!-- Brand and toggle get grouped for better mobile display -->

			<ul class="nav navbar-nav">
				<li <?php if(getPage()==""){ echo 'class="active"'; } ?>><a href="<?php echo getUrl('',"",true,array('repo'=>'','rev'=>'','rev2'=>'')) ?>"><?php echo t('home') ?></a></li>
			</ul>
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="">
			    <ul class="nav navbar-nav">
					<li class="dropdown <?php if(getPage()!=""){ echo 'active'; } ?>">
			          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('repos') ?> <span class="caret"></span></a>
			          <ul class="dropdown-menu scrollable-dropdown" role="menu">
			        	<?php
			        	// for ($i=0; $i < 20; $i++) { 
						  	foreach (getReposList() as $key => $repo) {
						  		?>
						  		<li <?php if($repo==getRepo()){ echo 'class="active"'; } ?> ><a href="<?php echo getUrl('repo',"",true,array('repo'=>$repo,'rev'=>'','rev2'=>'')) ?>"><?php echo $key ?></a></li>
						  		<?php
						  	}
			        	// }
						 ?>
			          </ul>
			        </li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-language"></span> <?php echo t('language') ?> <span class="caret"></span></a>
						<ul class="dropdown-menu scrollable-dropdown" role="menu">
			        	<?php
						  	foreach (getLangList() as $iso => $lang) {
						  		?>
						  		<li <?php if($iso==getLang()){ echo 'class="active"'; } ?>>
							  		<a href="<?php echo getUrl(getPage(),getPath(),true,array('lang'=>$iso)) ?>">
								  		<span> <img src="<?php echo getThemeRoot().'/flags/'.$iso.'.png' ?>"> </span>
								  		<span><?php echo $lang['name'] ?> <code><?php echo $lang['nativeName'] ?></code></span>
							  		</a>
						  		</li>

						  		<?php
						  	}
						 ?>

						 </ul>
					</li>
				</ul>




		    </div>
		  </div>
		</div>
	</nav>
	<div class="container">

		<div class="alert alert-danger noscript" role="alert"><?php echo t('noJs') ?></div>
		<script type="text/javascript">
			$('.noscript').css('display','none');
		</script>
		<?php
		if(!empty($errors)){
		?>
			<div class="row">
				<div class="col-md-12">
					<?php
					foreach ($errors as $key => $value) {
						echo '<div class="alert alert-danger" role="alert">'.$value.'</div>';
					}
					?>
				</div>
			</div>
		<?php
		}
		?>

