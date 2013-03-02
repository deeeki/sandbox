<?php
/**
 * Singleton class for PHP5.3
 * @link http://d.hatena.ne.jp/Yudoufu/20090811/1250021010
 */
abstract class Singleton {
	private static $instances = array();

	final private function __construct() {
		if (isset(self::$instances[get_called_class()])) {
			throw new Exception();
		}
		static::initialize();
	}

	protected function initialize() {
	}

	final public static function get_instance() {
		$class = get_called_class();
		if (!isset(self::$instances[$class])) {
			self::$instances[$class] = new static();
		}
		return self::$instances[$class];
	}

	final private function __clone() {
		throw new Exception();
	}
}
