<?php
function calc_time($func, $loop = 0, $output = true) {
    if (!function_exists($func)) { return; }

    $start = microtime(true);
    for ($i = 0; $i < $loop; $i++) {
        call_user_func($func);
    }
    $end = microtime(true);

$ret = $func . ' - ' . ($end - $start);
    if ($output) { echo $ret . "\n"; }
    return $ret;
}
