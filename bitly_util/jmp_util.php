<?php
/**
 * j.mp utility class
 *
 * PHP version 5.3
 *
 * @author  deeeki <http://twitter.com/deeeki>
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 */
require_once('bitly_util.php');
class JmpUtil extends BitlyUtil {
	const SHORTEN_API = 'http://api.j.mp/shorten?version=2.0.1&longUrl=%s&login=%s&apiKey=%s&format=json';
	const EXPAND_API = 'http://api.j.mp/expand?version=2.0.1&shortUrl=%s&login=%s&apiKey=%s&format=json';
}
