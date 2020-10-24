<?php

$keywords = explode("\n",file_get_contents("keywords.org"));

foreach ($keywords as $keyword) {
	$kwMD5 = md5($keyword);
	$filename = "counters/$kwMD5.counter";

	$count = "-";

	if (file_exists($filename)) {
		$count = file_get_contents($filename);
	}

	if ($count != "-") {
		echo $count."   $kwMD5    ".$keyword."\n";
	}
}
