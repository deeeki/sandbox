<?php
if (isset($argv[1])) {
	$input = $argv[1];
}
else {
	exit('Usage: php rader_graph_sample.php a=1_b=2_c=3__a=2_b=2_c=3 > out.png');
}

define('GRAPH_EXT', 'png');//拡張子
define('GRAPH_W', 200);//幅
define('GRAPH_H', 200);//高さ

require_once(dirname(__FILE__) . '/rader_graph.php');

$main = $sub = '';
if (strpos($input, '__') !== false) {
    list($main, $sub) = explode('__', $input);
} else {
    $main = $input;
}

$RaderGraph = new RaderGraph(GRAPH_EXT, GRAPH_W, GRAPH_H);
$RaderGraph->add_data(parse_params($main), array('graph' => 'blue@0.2', 'line' => 'blue@0.4'));
$RaderGraph->add_data(parse_params($sub), array('graph' => 'red@0.2', 'line' => 'red@0.4'));
$RaderGraph->output();

function parse_params($str) {
    if (strpos($str, '_') === false) {
        return array();
    }
    $tmp_params = explode('_', $str);
    $params = array();
    foreach ($tmp_params as $str) {
        if (strpos($str, '=') !== false) {
            list($k, $v) = explode('=', $str);
            $params[$k] = $v;
        }
        else {
            $params[] = $str;
        }
    }
    return $params;
}
