<!DOCTYPE html>
<?php
include_once("functions.php");

// Session Cleanup
$files = glob("sessions/*");
foreach($files as $file) {
	$filemtime=filemtime ($file);
	if (time()-$filemtime >= 20*60*60)
	{
		unlink($file);

		$honestyfiles = glob("counters/".str_replace("sessions/","",$file)."*");
		foreach ($honestyfiles as $hfile) {
			unlink($hfile);
		}
	}
	
}


?>
<html>
	<head>
		<title>Alpaca Bingo SPECTATOR <?php $id?></title>
		<link rel="stylesheet" type="text/css" href="spectator.css">
		<script src="jquery-3.5.1.min.js"></script>
	</head>
	<body>

<?php

	$sessionFile = "sessions/".$_GET['bingoCardId'];

	if (!file_exists($sessionFile)) {
		$keywords = getTiers();
		file_put_contents($sessionFile, implode("\n",$keywords));
	} else {
		$keywords = explode("\n",file_get_contents($sessionFile));
	}

	echo "<table>";
	for ($x = 0; $x <=4; $x++) {
		echo "<tr>\n";
		for ($y = 0; $y <=4;$y++) {

			$cellKeyword = $keywords[$x*5+$y];

			if ($cellKeyword == "") {
				echo "<td class='e' id='cell_".$x."_".$y."'> BONUS CELL </td>";			
			} else {

				$class = "d";
				$honestyFileName = "counters/".$_GET['bingoCardId'].".".md5($cellKeyword).".honesty";

				$honesty .= $honestyFileName."\n";
				if (file_exists($honestyFileName)) {
					$class = "e";
				}

				echo "<td class='bingocell $class' id='cell_".$x."_".$y."'>".$cellKeyword."</td>\n";
			}
		}
		echo "</tr>\n";
	}
	echo "</table>";


?>
<footer>
You are watching Bingo Card Id: <?php echo $_GET['bingoCardId'];  ?> - 
<a href="https://www.martinhohenberg.de/impressum.html">Impressum</a>
</footer>

	</body>
</html>
