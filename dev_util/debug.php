<?php
/**
 * debug with library
 */
if (!function_exists('d')) {
	function d() {
		if (!class_exists('dBug', false)) {
			require_once(dirname(__FILE__) . '/vendors/dBug.php');
		}
		foreach (func_get_args() as $v) new dBug($v);
	}
}

/**
 * debug preformatted var_dump
 */
if (!function_exists('v')) {
	function v() {
		echo '<pre style="background:#fff;color:#333;border:1px solid #ccc;margin:2px;padding:4px;font-family:monospace;font-size:12px">';
		foreach (func_get_args() as $v) var_dump($v);
		echo '</pre>';
	}
}
