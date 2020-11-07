<!DOCTYPE html>
<?php
session_start();

include_once("functions.php");

if ($_SESSION['bingoCardId'] == "") {
	$_SESSION['bingoCardId'] = guidv4();
	file_put_contents("logfile.txt", $_SESSION['bingoCardId']." | ".time()." | New Bingo Card created\n", FILE_APPEND);
}

cleanup();

?>
<html>
	<head>
		<title>Alpaca Bingo</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="js/jquery-3.5.1.min.js"></script>
		<script src="js/md5.js"></script>
		<script src="js/jquery.color-2.1.2.min.js"></script>
		<script>

		var notLocked = true;
		$.fn.animateHighlight = function(highlightColor, duration) {
			var highlightBg = highlightColor || "transparent";
			var animateMs = duration || 1500;
			var originalBg = this.css("background-color");
			if (notLocked) {
				notLocked = false;
				this.stop().css("background-color", highlightBg)
					.animate({backgroundColor: originalBg}, animateMs);
				setTimeout( function() { notLocked = true; }, animateMs);
			}
		};

		function checkBingo() {

			    // horizontally
			if ((($('#cell_0_0').hasClass('e')) && ($('#cell_0_1').hasClass('e')) && $('#cell_0_2').hasClass('e') && $('#cell_0_3').hasClass('e') && $('#cell_0_4').hasClass('e')) ||
			    (($('#cell_1_0').hasClass('e')) && ($('#cell_1_1').hasClass('e')) && $('#cell_1_2').hasClass('e') && $('#cell_1_3').hasClass('e') && $('#cell_1_4').hasClass('e')) ||
			    (($('#cell_2_0').hasClass('e')) && ($('#cell_2_1').hasClass('e')) && $('#cell_2_2').hasClass('e') && $('#cell_2_3').hasClass('e') && $('#cell_2_4').hasClass('e')) ||
			    (($('#cell_3_0').hasClass('e')) && ($('#cell_3_1').hasClass('e')) && $('#cell_3_2').hasClass('e') && $('#cell_3_3').hasClass('e') && $('#cell_3_4').hasClass('e')) ||
			    (($('#cell_4_0').hasClass('e')) && ($('#cell_4_1').hasClass('e')) && $('#cell_4_2').hasClass('e') && $('#cell_4_3').hasClass('e') && $('#cell_4_4').hasClass('e')) ||
		            // vertically
			    (($('#cell_0_0').hasClass('e')) && ($('#cell_1_0').hasClass('e')) && $('#cell_2_0').hasClass('e') && $('#cell_3_0').hasClass('e') && $('#cell_4_0').hasClass('e')) ||
			    (($('#cell_0_1').hasClass('e')) && ($('#cell_1_1').hasClass('e')) && $('#cell_2_1').hasClass('e') && $('#cell_3_1').hasClass('e') && $('#cell_4_1').hasClass('e')) ||
			    (($('#cell_0_2').hasClass('e')) && ($('#cell_1_2').hasClass('e')) && $('#cell_2_2').hasClass('e') && $('#cell_3_2').hasClass('e') && $('#cell_4_2').hasClass('e')) ||
			    (($('#cell_0_3').hasClass('e')) && ($('#cell_1_3').hasClass('e')) && $('#cell_2_3').hasClass('e') && $('#cell_3_3').hasClass('e') && $('#cell_4_3').hasClass('e')) ||
			    (($('#cell_0_4').hasClass('e')) && ($('#cell_1_4').hasClass('e')) && $('#cell_2_4').hasClass('e') && $('#cell_3_4').hasClass('e') && $('#cell_4_4').hasClass('e')) ||

			    // diagonally
			    (($('#cell_0_0').hasClass('e')) && ($('#cell_1_1').hasClass('e')) && $('#cell_2_2').hasClass('e') && $('#cell_3_3').hasClass('e') && $('#cell_4_4').hasClass('e')) ||
			    (($('#cell_4_0').hasClass('e')) && ($('#cell_3_1').hasClass('e')) && $('#cell_2_2').hasClass('e') && $('#cell_1_3').hasClass('e') && $('#cell_0_4').hasClass('e'))
		    	)

			{
				var a = document.getElementById('bingosound');
				a.play();
				setTimeout(function(){ 
					a.pause(); 
					a.currentTime = 0;
					alert('BINGO! Post the spectator link (bottom right) to the chat for verification');
	
					$("#spectatorLink").animateHighlight("#ffff00", 1000);

				}, 820);
			}

		}	

		function countTerm(term) {
			fetch('https://bingo.ty812.net/count.php?id='+term+'&session=<?php echo $_SESSION['bingoCardId']?>').catch(err => alert('term counting failed'));

		} 

	</script>
	</head>
	<body>

<div id="rules">Rules: Keep this open in a tab in the background. Click the appropriate field when it happens on stream. Shout BINGO into chat when you have your bingo card filled. </div>

<div id="logo">&nbsp;</div>

	<audio id="bingosound" loop= "false" volume="60">
		<source src="bingo.wav" id="bingo" type="audio/wav">
	</audio>
<?php

	$sessionFile = "sessions/".$_SESSION['bingoCardId'];

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
				$honestyFileName = "counters/".$_SESSION['bingoCardId'].".".md5($cellKeyword).".honesty";

				$honesty .= $honestyFileName."\n";
				if (file_exists($honestyFileName)) {
					$class = "e";
				}

				echo "<td onclick=\"$(this).toggleClass('e').toggleClass('d');checkBingo();countTerm('".md5($cellKeyword)."')\" class='bingocell $class' id='cell_".$x."_".$y."'>".$cellKeyword."</td>\n";
			}
		}
		echo "</tr>\n";
	}
	echo "</table>";


?>
<footer>
Bingo Card Id: <?php echo $_SESSION['bingoCardId']; ?> [<a href="https://bingo.ty812.net/spectator.php?bingoCardId=<?php echo $_SESSION['bingoCardId'];?>" target="_new" id="spectatorLink">Spectator link</a>] - 
<a href="https://www.martinhohenberg.de/impressum.html">Impressum</a>
</footer>

	</body>
</html>
