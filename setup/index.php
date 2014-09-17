<?php
$check_errors = array();
if( basename($_SERVER['REQUEST_URI'], ".php")!="index"){
	die('<meta http-equiv="refresh" content=0;URL=index.php>'); 
}

include 'header.php';
?>
<table class="table table-bordered">

	<?php
	if(@getCommand("php -r 'echo \"1\";'")[0] == 1 && function_exists('exec')){
	?>
		<tr class="success">
			<td>Exec() function</td>
			<td>OK</td>
		</tr>
	<?php
	}else{
	$check_errors[]="1";
	?>
		<tr class="danger">
			<td>Fonctio exec()</td>
			<td>SvnAdmin require fonction <code>exec()</code></td>
		</tr>
	<?php
	}
	?>



	<?php
	if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN'){
	?>
		<tr class="success">
			<td>OS</td>
			<td>OK</td>
		</tr>
	<?php
	}else{
	$check_errors[]="1";
	?>
		<tr class="danger">
			<td>OS</td>
			<td>SvnAdmin require to be runned in Linux</td>
		</tr>
	<?php
	}
	?>


	<?php
	if(ini_get("max_execution_time") >= 60){
	?>
		<tr class="success">
			<td>Timeout</td>
			<td>OK ( <?php echo ini_get("max_execution_time") ?>s )</td>
		</tr>
	<?php
	}else{
	$check_errors[]="1";
	?>
		<tr class="warning">
			<td>Timeout</td>
			<td>Timeout must be greater than 60 seconds</td>
		</tr>
	<?php
	}
	?>

	<?php
	if( count(@getCommand("svn",0)) == 1 ){
	?>
		<tr class="success">
			<td>SVN</td>
			<td>OK</td>
		</tr>
	<?php
	}else{
	$check_errors[]="1";
	?>
		<tr class="danger">
			<td>SVN</td>
			<td>Svn package must be installed</td>
		</tr>
	<?php
	}
	?>

	<?php
	if(count($check_errors)){
		$disabled = 'disabled="disabled"';
	}
	?>
</table>
<a href="config.php" data-loading-text="Loading..." <?php echo $disabled; ?> class="btn btn-primary">Continue</a>
<?php
include 'footer.php';
?>