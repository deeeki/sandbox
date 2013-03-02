<?php
/**
 * ow.ly image download script
 * arg1: target user url
 * arg2: page limit
 */
if (!$url = $argv[1]) {
	exit("require target url : ex) php -q owly.php http://ow.ly/user/xxx 10\n");
}
$limit = ($argv[2]) ?: 1;

$images = array();
for($i = 1; $i <= $limit; $i++) {
	$target = $url . '?&page=' . $i;
	$ret = scrape($target);
	$images = array_merge($images, $ret);
}

foreach ($images as $image) {
	exec('wget -q '. $image, $output, $return_var);
}

echo implode("\n", $images) . "\n";

function scrape($url) {
	$content = file_get_contents($url);
	preg_match_all('!<a [^>]* href="http://ow\.ly/i/([^\"]+)"[^>]*>!s', $content, $matches);
	$ret = array();
	foreach ($matches[1] as $id) {
		$ret[] = 'http://static.ow.ly/photos/original/' . $id . '.jpg';
	}
	return $ret;
}

