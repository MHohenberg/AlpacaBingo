<?php

function cleanup($maxAge = 7200) {

	// Session Cleanup
	$files = glob("sessions/*");
	foreach($files as $file) {
		$filemtime=filemtime ($file);
		if (time()-$filemtime >= $maxAge)
		{
			unlink($file);

			file_put_contents("logfile.txt", $_SESSION['bingoCardId']." | ".time()." | TIMEOUT File $file deleted\n", FILE_APPEND);
			$honestyfiles = glob("counters/".str_replace("sessions/","",$file)."*");
			foreach ($honestyfiles as $hfile) {
				unlink($hfile);
				file_put_contents("logfile.txt", $_SESSION['bingoCardId']." | ".time()." | TIMEOUT Honestyfile $file deleted \n", FILE_APPEND);
			}
		}
	}                                                                                                           
}

function guidv4()
{
	if (function_exists('com_create_guid') === true)
		return trim(com_create_guid(), '{}');

	$data = openssl_random_pseudo_bytes(16);
	$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
	$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
	return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


function getTiers() {

	return array_merge(getTier(1,15), getTier(2,5), gettier(3,5));

}

function getTier($tier, $number=15) {

	$keywords = explode("\n",file_get_contents("keywords.org"));
	$elementsByTier = floor(count($keywords)/3);
	$tierKws = [];

	foreach ($keywords as $kw) {
		$tierKws[$kw] = 0;

		$kwMD5 = md5($kw);
		$filename = "counters/$kwMD5.counter";

		if (file_exists($filename)) {
			$tierKws[$kw] = file_get_contents($filename);
		}
	}

	arsort($tierKws);
	$tierKws = array_splice($tierKws, ($tier-1)*$elementsByTier, $elementsByTier);

	$tierkw = [];
	foreach ($tierKws as $key=>$value) {
		$tierkw[] = $key;
	}

	shuffle($tierkw);
	$tierkw = array_splice($tierkw, 0, $number);
	
	return $tierkw;
}
