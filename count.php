<?php

if ($_GET['id']) {

	$filename = "counters/".$_GET['id'].".counter";

	if (!file_exists($filename)) {
		file_put_contents($filename, "1");
	} else {
		$count = file_get_contents($filename)+1;
		file_put_contents($filename, $count);
	}
}

?>
