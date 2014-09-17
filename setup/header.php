<?php 
error_reporting(E_ALL);
ini_set("display_errors", 0);

if(file_exists('../config.php')){
    include "../config.php";
}elseif(file_exists('../config.sample.php')){
    include "../config.sample.php";
}else{
    echo "Le systeme a besoin au minimum du fichier config.sample.php";
    exit;
}

require "../functions.php";

function getStepClass($file='') {
    $requestedFile = basename($_SERVER['REQUEST_URI'], ".php");

    if($requestedFile=="index"){
        if($file=="check"){
            return "active";
        }elseif($file==("config" OR "install")){
            return "disabled";
        }
    }elseif($requestedFile=="config"){
        if($file=="check"){
            return "enabled";
        }elseif($file=="config"){
            return "active";
        }elseif($file=="install"){
            return "disabled";
        }
    }elseif($requestedFile=="install"){
        if($file=="install"){
            return "active";
        }elseif($file==("config" OR "check")){
            return "enabled";
        }
    }else{
        return "##ERROR##";
    }
}

function getStepLink($file='',$link='') {
    $requestedFile = basename($_SERVER['REQUEST_URI'], ".php");

    if($requestedFile=="config"){
        if($file=="check"){
            return 'href="'.$link.'"';
        }
    }elseif($requestedFile=="install"){
        if($file==("config" OR "check")){
            return 'href="'.$link.'"';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Repos</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="password.js"></script>

    <script type="text/javascript">
    $(function() {
        $('[data-loading-text]').click(function () {
            var btn = $(this);
            btn.button('loading');
        });
        $('input[type="password"]').password();
    });
    </script>

	<style>
	*{
		outline: none;
	}
	li.L0, li.L1, li.L2, li.L3,
	li.L5, li.L6, li.L7, li.L8
	{ list-style-type: decimal !important }
	</style>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">SvnAdmin</a>
		      <a class="navbar-text"><small>Installation</small></a>
		    </div>
		  </div><!-- /.container-fluid -->
		</nav>

	<div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                <li class="<?php echo getStepClass('check') ?>"><a <?php echo getStepLink('check','./index.php') ?>>
                    <h4 class="list-group-item-heading">#1 - Check</h4>
                    <p class="list-group-item-text">Checking your system config</p>
                </a></li>
                <li class="<?php echo getStepClass('config') ?>"><a <?php echo getStepLink('config','./config.php') ?>>
                    <h4 class="list-group-item-heading">#2 - Config</h4>
                    <p class="list-group-item-text">Setting up your SvnAdmin client</p>
                </a></li>
                <li class="<?php echo getStepClass('install') ?>"><a <?php echo getStepLink('install','./install.php') ?>>
                    <h4 class="list-group-item-heading">#3 - Install</h4>
                    <p class="list-group-item-text">Creating your config file</p>
                </a></li>
            </ul>
        </div>
	</div>
