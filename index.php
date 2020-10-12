<?php

	echo "Miniden Bingo";

	$keywords = file_get_contents("keywords.org");

	for (x = 0; x <=4; x++) {
		echo "<tr>";
		for (y = 0; y <=4;y++) {
			echo "<td>".$keywords[x*5+y]."</td>";
		}
		echo "</tr>"
	}


?>
