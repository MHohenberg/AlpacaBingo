<?php

function isValidMd5($md5 ='')
{
	    return preg_match('/^[a-f0-9]{32}$/', $md5);
}


if ($_GET['id'] && isValidMd5($_GET['id']) {

	$filename = "counters/".$_GET['id'].".counter";

	if (!file_exists($filename)) {
		file_put_contents($filename, "1");
	} else {
		$count = file_get_contents($filename)+1;
		file_put_contents($filename, $count);
	}
} else {
	header("400 Bad Request");

?>
