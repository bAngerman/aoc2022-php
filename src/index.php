<?php

require __DIR__  . '/../vendor/autoload.php';

/**
 * Usage:
 * 
 * php src/index.php {day_number}
 * eg. php src/index.php 2
 * will run Day2 class
 */

if ( ! isset($argv[1]) || ! (int) $argv[1] === 0 ) {
    throw new \ParseError("Pass an integer for the day to the php cli command.\neg \"php src/index.php 1\" for day 1\n");
}

$class = sprintf("AOC2022\Day%s\Day%s", $argv[1], $argv[1]);

if ( ! class_exists( $class) ) {
    throw new \ParseError("Class not found: " . $class);
}

(new $class)->run();
