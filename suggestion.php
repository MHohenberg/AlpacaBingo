<?php

session_start();

if (($_REQUEST['term'] != "") && (preg_match('/^[a-z0-9 .\-\*\!\,]+$/i', $_REQUEST['term']))) {
	$_SESSION['suggestions'] = $_SESSION['suggestions']++;
	file_put_contents("newSuggestions.org", $_REQUEST['term']."\n",FILE_APPEND);
}
