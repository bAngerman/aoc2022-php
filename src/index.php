<?php

require __DIR__  . '/../vendor/autoload.php';

/**
 * Usage:
 * 
 * php src/index.php {day_number}
 * eg. php src/index.php 2
 * will run Day2 class
 */

$class = sprintf("AOC2022\Day%s\Day%s", $argc, $argc);

if ( ! class_exists( $class) ) {
    throw new \ParseError("Class not found: " . $class);
}

(new $class)->run();
