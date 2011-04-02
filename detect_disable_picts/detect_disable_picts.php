<?php
require_once('HTML/Emoji.php');
$emoji = HTML_Emoji::getInstance();
$pict_contents = file_get_contents('picts.txt');
$picts = explode("\n", $pict_contents);
$picts_a = explode("\n", HTML_Emoji::getInstance('au')->filter($pict_contents, array('Output')));
$picts_s = explode("\n", HTML_Emoji::getInstance('softbank')->filter($pict_contents, array('Output')));
$disable_picts_a = detect_disable_picts($picts_a);
$disable_picts_s = detect_disable_picts($picts_s);

$disable_idxs = array_unique(array_merge(array_keys($disable_picts_a), array_keys($disable_picts_s)));
sort($disable_idxs);
$disable_picts = array();
foreach ($disable_idxs as $idx) {
	$disable_picts[] = $picts[$idx];
}

function detect_disable_picts($picts = array()) {
	$disables = array();
	foreach ($picts as $idx => $pict) {
		if (strpos($pict, '[') === 0) {
			$disables[$idx] = $pict;
		}
	}
	return $disables;
}

if (isset($argv[0])) {
	echo implode(' ', $disable_picts);
	exit;
}

if ($emoji->isSjisCarrier()) {
	header('Content-Type: application/xhtml+xml; charset=Shift_JIS');
}
else {
	header('Content-Type: application/xhtml+xml; charset=UTF-8');
}
echo $emoji->filter(implode(' ', $disable_picts), array('Output'));
