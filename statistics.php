<html>
<head>
	<title>Internal Statistics / Alpaca Bingo</title>
<script type="text/javascript">

function sortTable(n) {
	  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	    table = document.getElementById("termstable");
	    switching = true;

  dir = "asc";


  while (switching) {

    switching = false;
    rows = table.rows;

    for (i = 1; i < (rows.length - 1); i++) {

      shouldSwitch = false;


      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}


</script>

</head>
<body>
<header>
<a href='#terms'>Bingo Terms</a> 
<a href='#sessions'>Sessions</a>
<a href='#newSuggestions'>New Suggestions</a>
</header>

<?php

$sessionsNum = 0;
$filledCards = 0;
$bestFilled = 0;
$files = glob("sessions/*");
foreach($files as $file) {
	$sessionId = str_replace("sessions/","",$file);
	$linklist .= "<li><a href='https://bingo.ty812.net/spectator.php?bingoCardId=$sessionId' target=_new>$sessionId</a></li>";
	$sessionsNum++;
	$sessionCompletion = 0;
	$sessionclickFiles = glob("sessionclick/".$sessionId."*");
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

echo "<table><tr><td>";

echo "<table>";

echo "<tr><th>Currently active sessions/players</th><td>$sessionsNum</td></tr>";
echo "<tr><th>Search Terms per session</th><td>$sessionCompletion</td></tr>";

echo "</table>";
echo "</td><td>";

echo "<ul>$linklist</ul>"; 

echo "</td></tr></table>";



echo "<h1 id='newSuggestions'>New Suggestions</h1>";
echo "<pre>";
echo file_get_contents("newSuggestions.org");
echo "</pre>";




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
			$lastClaimed = date("yy-m-d H:i:s", filemtime($filename));
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
echo "<table style='width:80%;margin:auto' id='termstable'>";
echo "<tr><th onclick='sortTable(0)'>Times claimed</th><th onclick='sortTable(1)'>Bingo card</th><th onclick='sortTable(2)'>Last claimed</th></tr>";
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

?>
</body>
</html>
