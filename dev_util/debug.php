<?php
// useful to set "auto_prepend_file" on php.ini

/**
 * dump debug with "dBug" library
 */
if (!function_exists('d')) {
	if (!class_exists('dBug', false)) {
		require_once(dirname(__FILE__) . '/vendor/dBug.php');
	}
	function d() {
		foreach (func_get_args() as $v) new dBug($v);
	}
}

/**
 * shorthand "var_dump" with decoration
 */
if (!function_exists('v')) {
	function v() {
		echo '<pre style="background:#fff;color:#333;border:1px solid #ccc;margin:2px;padding:4px;font-family:monospace;font-size:12px">';
		foreach (func_get_args() as $v) var_dump($v);
		echo '</pre>';
	}
}
