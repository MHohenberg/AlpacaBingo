<html>
<head>
	<title>Internal Statistics / Alpaca Bingo</title>
</head>
<body>
<header>
<a href='#terms'>Bingo Terms</a> 
<a href='#sessions'>Sessions</a>
</header>
<?php

$keywords = explode("\n",file_get_contents("keywords.org"));

$terms = [];

foreach ($keywords as $keyword) {
	$kwMD5 = md5($keyword);
	$filename = "counters/$kwMD5.counter";

	$count = 0;

	$lastClaimed = "n/a";

	if (file_exists($filename)) {
		$count = file_get_contents($filename);
		if ($count > 0) {
			$lastClaimed = date("yy-m-d h:i:s", filemtime($filename));
		}
	}

	if ($count < 10) {
		$count = "0".$count;
	}

	array_push($terms, "<td>".$count."</td><td>".$keyword."</td><td>$lastClaimed</td>");
}

rsort($terms);
$termsPerTier = count($terms)/3;

echo "<h1 id='terms'>Bingo Terms</h1>";
echo "<table style='width:80%;margin:auto'>";
echo "<tr><th>Times claimed</th><th>Bingo card</th><th>Last claimed</th></tr>";
foreach ($terms as $term) {
	$i++;
	if ($i < $termsPerTier) {
		$backgroundcolor = "#dfd";
	} elseif ($i < $termsPerTier*2) {
		$backgroundcolor = "#dff";
	} else {
		$backgroundcolor = "#fdd";
	}
	echo "<tr style='background-color:$backgroundcolor'>$term</tr>";
}

echo "</table>";
////////////////////////////

$sessionsNum = 0;
$filledCards = 0;
$bestFilled = 0;
$files = glob("sessions/*");
foreach($files as $file) {
	$sessionsNum++;
	$sessionCompletion = 0;
	$sessionclickFiles = glob("sessionclick/".str_replace("sessions/","",$file)."*");
	foreach ($sessionclickFiles as $hf) {
		$filledCards++;
		$sessionCompletion++;
	}
	if ($bestFilled < $sessionCompletion) {
		$bestFilled = $sessionCompletion;
	}
}

$sessionCompletion = $filledCards." (".round($filledCards/$sessionsNum,2)." per session // best filled: ".$bestFilled.")";

echo "<h1 id='session'>Sessions</h1>";
echo "<table>";

echo "<tr><th>Currently active sessions/players</th><td>$sessionsNum</td></tr>";
echo "<tr><th>Search Terms per session</th><td>$sessionCompletion</td></tr>";

echo "</table>";

?>
</body>
</html>
