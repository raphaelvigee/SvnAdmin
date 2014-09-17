<?php
if(file_exists('config.php')){
	require 'config.php';
}else{
	header("Location: ./setup/");
}
date_default_timezone_set("UTC");

define('rootPath', __DIR__);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date dans le passé

require 'functions.php';
require 'routing.php';

if(isset($routes[getPage()]["headers"])){
	foreach ($routes[getPage()]["headers"] as $key => $value) {
		header($value);
	}
}else{	
	header('Content-Type: text/html; charset=utf-8');
}

if(@$routes[getPage()]['page']!="index"){
    requireAuth();
}

if(@$routes[getPage()]["container"]==true OR !isset($routes[getPage()]["container"]) ){
	include 'themes/'.get('Theme').'/header.php';
}

if(intval(get('MaxSizeTmpDir'))!=0 && filesize(get('TmpPath'))>intval(get('MaxSizeTmpDir')) ){
    include 'themes/'.get('Theme').'/max-tmp.php';
}

if(   !file_exists('themes/'.get('Theme').'/'.$routes[getPage()]['page'].'.php') ){
	include 'themes/'.get('Theme').'/404-page.php';
}elseif(   (getRepo() != "") AND !in_array(getRepo(), getReposList())   ){
	include 'themes/'.get('Theme').'/404-repo.php';
}else{
	include 'themes/'.get('Theme').'/'.$routes[getPage()]['page'].'.php';
}

if(@$routes[getPage()]["container"]==true OR !isset($routes[getPage()]["container"]) ){
	include 'themes/'.get('Theme').'/footer.php';
}

?>
