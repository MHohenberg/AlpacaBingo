<?php

	print "Miniden Bingo";

	$keywords = file_get_contents("keywords.org");

	for (x = 0; x <=4; x++) {
		print "<tr>";
		for (y = 0; y <=4;y++) {
			print "<td>".$keywords[x*5+y]."</td>";
		}
		print "</tr>"
	}


?>
