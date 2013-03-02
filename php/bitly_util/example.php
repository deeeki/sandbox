<?php
$url = 'http://php.net/';

require_once('bitly_util.php');
$short = BitlyUtil::shorten($url);
$long = BitlyUtil::expand($short);
echo (($url === $long) ? '[OK]' : '[NG]') . $url . "\n";
echo $short . "\n" . $long . "\n";

require_once('jmp_util.php');
$short = JmpUtil::shorten($url);
$long = JmpUtil::expand($short);
echo (($url === $long) ? '[OK]' : '[NG]') . $url . "\n";
echo $short . "\n" . $long . "\n";
