<?php
class MobileDispatcher {
    const EXTENSION = '.html';

    static public function route() {
        $base_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', dirname(__FILE__)));
        $path = array_shift(explode('?', $_SERVER['REQUEST_URI']));
        if ($base_path) {
            $path = str_replace($base_path . '/', '', $path);
        }
        $path = trim($path, '/');
        return ($path) ? $path : 'index';
    }

    static public function render($target = 'index') {
        $file = dirname(__FILE__) . '/' . $target . self::EXTENSION;
        if (!is_readable($file)) {
            header('HTTP/1.0 404 Not Found');
            exit;
        }
        require_once(dirname(__FILE__) . '/vendors/HTML/Emoji.php');
		if (HTML_Emoji::getInstance()->isSjisCarrier()) {
			header('Content-Type: application/xhtml+xml; charset=Shift_JIS');
		}
		else {
			header('Content-Type: application/xhtml+xml; charset=UTF-8');
		}
        ob_start();
        include $file;
        echo HTML_Emoji::getInstance()->filter(ob_get_clean(), array('HexToUtf8', 'Output'));
    }

    static public function dispatch() {
        self::render(self::route());
    }
}

MobileDispatcher::dispatch();
