<?php
/**
 * bit.ly utility class
 *
 * PHP version 5.3
 *
 * @author  deeeki <http://twitter.com/deeeki>
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class BitlyUtil {
	const BITLY_USER = 'your-user-name';
	const BITLY_API_KEY = 'your-api-key';
	const SHORTEN_API = 'http://api.bit.ly/shorten?version=2.0.1&longUrl=%s&login=%s&apiKey=%s&format=json';
	const EXPAND_API = 'http://api.bit.ly/expand?version=2.0.1&shortUrl=%s&login=%s&apiKey=%s&format=json';

	public static function shorten($url) {
		$str = file_get_contents(sprintf(static::SHORTEN_API, $url, static::BITLY_USER, static::BITLY_API_KEY));
		$r = json_decode($str, true);
		if ($r['errorCode'] > 0) {
			throw new Exception('[ERROR]' . $r['errorMessage']);
		}
		$data = array_pop($r['results']);
		return $data['shortUrl'];
	}

	public static function expand($url) {
		$str = file_get_contents(sprintf(static::EXPAND_API, $url, static::BITLY_USER, static::BITLY_API_KEY));
		$r = json_decode($str, true);
		if ($r['errorCode'] > 0) {
			throw new Exception('[ERROR]' . $r['errorMessage']);
		}
		$data = array_pop($r['results']);
		return $data['longUrl'];
	}
}