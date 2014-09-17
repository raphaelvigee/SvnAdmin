<?php
if(file_exists(TmpPath.'/'.$_GET['file'].'.zip')){
	readfile(TmpPath.'/'.$_GET['file'].'.zip');
}
?>