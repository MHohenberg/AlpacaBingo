<?php

$keywords = explode("\n",file_get_contents("keywords.org"));

$lines = [];

foreach ($keywords as $keyword) {
	$kwMD5 = md5($keyword);
	$filename = "counters/$kwMD5.counter";

	$count = "-";

	if (file_exists($filename)) {
		$count = file_get_contents($filename);
	}

	if ($count != "-") {
		array_push($lines, "<td>".$count."</td><td>$kwMD5</td><td>".$keyword."</td>");
	}
}

rsort($lines);
$linespertier = count($lines)/3;

echo "Lines per tier: $linespertier";

echo "<table style='width:80%;margin:auto'>";
foreach ($lines as $line) {
	$i++;
	if ($i < $linespertier) {
		$backgroundcolor = "#dfd";
	} elseif ($i < $linespertier*2) {
		$backgroundcolor = "#dff";
	} else {
		$backgroundcolor = "#fdd";
	}
	echo "<tr style='background-color:$backgroundcolor'>$line</tr>";
}
echo "</table>";
