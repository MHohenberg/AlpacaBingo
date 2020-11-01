<?php

function isValidMd5($md5 ='')
{
	    return preg_match('/^[a-f0-9]{32}$/', $md5);
}


if ($_GET['id'] && isValidMd5($_GET['id'])) {

	$filename = "counters/".$_GET['id'].".counter";
	$honestyFileName = "counters/".$_GET['session'].".".$_GET['id'].".honesty";

	if (!file_exists($honestyFileName)) {

		$fh = fopen($honestyFileName, 'a');
		fwrite($fh, '<h1>Hello world!</h1>');
		fclose($fh);

		if (!file_exists($filename)) {
			file_put_contents($filename, "1");
		} else {
			$count = file_get_contents($filename)+1;
			file_put_contents($filename, $count);
		}
	} else {
		unlink($honestyFileName);
		if (file_exists($filename)) {
			$count = file_get_contents($filename)-1;
			file_put_contents($filename, $count);
		}
	}
} else {
	header("400 Bad Request");
}
