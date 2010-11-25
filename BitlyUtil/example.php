<?php
$url = 'http://php.net/';

require_once('BitlyUtil.php');
$short = BitlyUtil::shorten($url);
$long = BitlyUtil::expand($short);
echo (($url === $long) ? '[OK]' : '[NG]') . $url . "\n";
echo $short . "\n" . $long . "\n";

require_once('JmpUtil.php');
$short = JmpUtil::shorten($url);
$long = JmpUtil::expand($short);
echo (($url === $long) ? '[OK]' : '[NG]') . $url . "\n";
echo $short . "\n" . $long . "\n";
