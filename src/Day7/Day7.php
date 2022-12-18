<?php

namespace AOC2022\Day7;

use AOC2022\BaseClass;

class Day7 extends BaseClass
{
    public array $fs;
    public array $seen = [];
    public array $sizes = [];
    
    public function setupPath() : void
    {
        $this->file_path = __DIR__ . '/input.txt';
    }

    public function run() : void
    {
        // Remove first command because it is a cd to root dir.
        array_shift($this->data);

        $this->part1();
        $this->part2();
    }

    public static function fsSet(&$array, $key, $value) : array
    {
        $keys = explode(".", $key);

        foreach ($keys as $i => $key) {
            if (count($keys) === 1) {
                break;
            }

            unset($keys[$i]);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    public static function fsGet($key, $array) : array
    {
        if (! str_contains($key, '.')) {
            return $array[$key];
        }

        foreach (explode(".", $key) as $segment) {
            $array = $array[$segment];
        }

        if ( is_null($array) ) {
            dd( $key, explode(".", $key) );
        }

        return $array;
    }

    public function buildfileSystem() : void
    {
        $fs = [
            "/" => []
        ];
        $ptr = "/";

        foreach ( $this->data as $idx => $output ) {
            // dd( $output );
            // A command to change directory.
            if ( substr($output, 0, 1) === "$" ) {
                $parts = explode(" ", $output );
                $command = $parts[1];

                if ( $command === "ls" ) {
                    // Sync directory to $fs
                    // We are going to take care of this in the else condition.
                } 
                // A cd command to change directory.
                else if ( $command === "cd" ) {
                    $cd_arg = $parts[2];
                    if ( $cd_arg === ".." ) {
                        // Move pointer back up a directory.
                        $ptr = substr($ptr, 0, strrpos($ptr, "."));

                    } else {
                        // Move pointer to new directory.
                        $ptr = $ptr . "." . $cd_arg;
                    }
                }
            }
            // Create a file / directory in our fs.
            else {
                [$dir_or_size, $name] = explode(" ", $output );

                if ( $dir_or_size === "dir" ) {
                    // Create directory at pointer location.
                    $new_dir = [
                        $name => [],
                    ];

                    self::fsSet($fs, $ptr, array_merge($new_dir, self::fsGet($ptr, $fs)));

                } else {
                    // Create file with size.
                    $new_file = [
                        $name => $dir_or_size,
                    ];

                    self::fsSet($fs, $ptr, array_merge($new_file, self::fsGet($ptr, $fs)));
                }
            }
        }

        $this->fs = $fs;
        return;
    }

    public function getDirectorySizes(string $ptr) : string
    {
        foreach ( self::fsGet($ptr, $this->fs) as $item_name => $item_value ) {
            if ( is_array($item_value) ) {
                $new_ptr = $ptr . "." . $item_name;
                $this->getDirectorySizes($new_ptr);
            } else {

                // If this directory does not yet have a size we need to set it to zero.
                if ( ! isset( $this->sizes[$ptr] ) ) {
                    $this->sizes[$ptr] = 0;
                }
                // If we have not seen this file yet, add it to the list of seen items.
                if ( ! isset( $this->seen[$ptr . "." . $item_name] ) ) {
                    $this->sizes[$ptr] += (int) $item_value;
                    $this->seen[$ptr . "." . $item_name] = true;
                }
            }
        }

        return $ptr;
    }

    public function part1() : void
    {
        $this->buildFilesystem();
        $this->getDirectorySizes("/");

        $size_sum = 0;
        foreach ( $this->sizes as $s ) {
            if ( $s <= 100000 ) {
                $size_sum += $s;
            }
        }

        $this->part1_answer = $size_sum;
    }

    public function part2() : void
    {
        
    }
}
