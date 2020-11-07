<!DOCTYPE html>
<?php
include_once("functions.php");

cleanup();
?>
<html>
	<head>
		<title>Alpaca Bingo SPECTATOR <?php $id?></title>
		<link rel="stylesheet" type="text/css" href="css/spectator.css">
	</head>
	<body>
<div id="logo">&nbsp;</div>

<?php

$sessionFile = "sessions/".$_GET['bingoCardId'];

if (!file_exists($sessionFile)) {

	echo "<div id='error'>This bingo card does not seem to exist. Chances are that the session has been removed for inactivity after a few hours.</div>";

	} else {
		$keywords = explode("\n",file_get_contents($sessionFile));
	

	echo "<table>";
	for ($x = 0; $x <=4; $x++) {
		echo "<tr>\n";
		for ($y = 0; $y <=4;$y++) {

			$cellKeyword = $keywords[$x*5+$y];

			if ($cellKeyword == "") {
				echo "<td class='e' id='cell_".$x."_".$y."'> BONUS CELL </td>";			
			} else {

				$class = "d";
				$sessionclickFileName = "sessionclick/".$_GET['bingoCardId'].".".md5($cellKeyword).".sessionclick";

				$sessionclick .= $sessionclickFileName."\n";
				if (file_exists($sessionclickFileName)) {
					$class = "e";
				}

				echo "<td class='bingocell $class' id='cell_".$x."_".$y."'>".$cellKeyword."</td>\n";
			}
		}
		echo "</tr>\n";
	}
	echo "</table>";
	}

?>
<footer>
You are watching Bingo Card Id: <?php echo $_GET['bingoCardId'];  ?> - 
<a href="https://www.martinhohenberg.de/impressum.html">Impressum</a>
</footer>

	</body>
</html>
