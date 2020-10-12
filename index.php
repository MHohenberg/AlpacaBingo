<?php

	echo "Miniden Bingo";

	$keywords = explode("\n",file_get_contents("keywords.org"));
	shuffle($keywords);
	echo "<table>";
	for ($x = 0; $x <=4; $x++) {
		echo "<tr>";
		for ($y = 0; $y <=4;$y++) {
			echo "<td style='border:1px solid orange'>".$keywords[$x*5+$y]."</td>";
		}
		echo "</tr>";
	}
	echo "</table>";


?>
