<!DOCTYPE html>
<html>
	<head>
		<title>Alpaca Bingo</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="jquery-3.5.1.min.js"></script>
	<script>
		function checkBingo() {

			var bingo = false;

			if ((($('#cell_0_0').hasClass('e')) && ($('#cell_0_1').hasClass('e')) && $('#cell_0_2').hasClass('e') && $('#cell_0_3').hasClass('e') && $('#cell_0_4').hasClass('e')) ||
			    (($('#cell_1_0').hasClass('e')) && ($('#cell_1_1').hasClass('e')) && $('#cell_1_2').hasClass('e') && $('#cell_1_3').hasClass('e') && $('#cell_1_4').hasClass('e')) ||
			    (($('#cell_2_0').hasClass('e')) && ($('#cell_2_1').hasClass('e')) && $('#cell_2_2').hasClass('e') && $('#cell_2_3').hasClass('e') && $('#cell_2_4').hasClass('e')) ||
			    (($('#cell_3_0').hasClass('e')) && ($('#cell_3_1').hasClass('e')) && $('#cell_3_2').hasClass('e') && $('#cell_3_3').hasClass('e') && $('#cell_3_4').hasClass('e')) ||
			    (($('#cell_4_0').hasClass('e')) && ($('#cell_4_1').hasClass('e')) && $('#cell_4_2').hasClass('e') && $('#cell_4_3').hasClass('e') && $('#cell_4_4').hasClass('e')) ||

			    (($('#cell_0_0').hasClass('e')) && ($('#cell_1_0').hasClass('e')) && $('#cell_2_0').hasClass('e') && $('#cell_3_0').hasClass('e') && $('#cell_4_0').hasClass('e')) ||
			    (($('#cell_0_1').hasClass('e')) && ($('#cell_1_1').hasClass('e')) && $('#cell_2_1').hasClass('e') && $('#cell_3_1').hasClass('e') && $('#cell_4_1').hasClass('e')) ||
			    (($('#cell_0_2').hasClass('e')) && ($('#cell_1_2').hasClass('e')) && $('#cell_2_2').hasClass('e') && $('#cell_3_2').hasClass('e') && $('#cell_4_2').hasClass('e')) ||
			    (($('#cell_0_3').hasClass('e')) && ($('#cell_1_3').hasClass('e')) && $('#cell_2_3').hasClass('e') && $('#cell_3_3').hasClass('e') && $('#cell_4_3').hasClass('e')) ||
			    (($('#cell_0_4').hasClass('e')) && ($('#cell_1_4').hasClass('e')) && $('#cell_2_4').hasClass('e') && $('#cell_3_4').hasClass('e') && $('#cell_4_4').hasClass('e')) ||


			    (($('#cell_0_0').hasClass('e')) && ($('#cell_1_1').hasClass('e')) && $('#cell_2_2').hasClass('e') && $('#cell_3_3').hasClass('e') && $('#cell_4_4').hasClass('e')) ||
			    (($('#cell_4_0').hasClass('e')) && ($('#cell_3_1').hasClass('e')) && $('#cell_2_2').hasClass('e') && $('#cell_1_3').hasClass('e') && $('#cell_0_4').hasClass('e'))
		    	)

			{
				bingo = true;
				var a = document.getElementById('bingosound');
				a.play();
				setTimeout(function(){ 
					a.pause(); 
					a.currentTime = 0
				}, 820);

			}

		}	
	</script>
	</head>
	<body>

<div class="rules">Rules: Keep open. Press the appropriate field when it happens on stream. Shout BINGO into chat when you have your bingo card filled. </div>

	<audio id="bingosound" loop= "false" volume="60">
		<source src="bingo.wav" id="bingo" type="audio/wav">
	</audio>
<?php

	$keywords = explode("\n",file_get_contents("keywords.org"));
	shuffle($keywords);
	echo "<table>";
	for ($x = 0; $x <=4; $x++) {
		echo "<tr>\n";
		for ($y = 0; $y <=4;$y++) {
			if ($keywords[$x*5+$y] == "") {
				echo "<td class='e' id='cell_".$x."_".$y."'> BONUS CELL </td>";			
			} else {

				echo "<td onclick=\"$(this).toggleClass('e').toggleClass('d');checkBingo();\" class='bingocell d' id='cell_".$x."_".$y."'>".$keywords[$x*5+$y]."</td>\n";
			}
		}
		echo "</tr>\n";
	}
	echo "</table>";


?>
<footer>
<a href="https://www.martinhohenberg.de/impressum.html">Impressum</a>
</footer>

	</body>
</html>
