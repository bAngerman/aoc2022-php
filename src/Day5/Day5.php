<?php

namespace AOC2022\Day5;

use AOC2022\BaseClass;

class Day5 extends BaseClass
{
    public function setupPath() : void
    {
        $this->file_path = __DIR__ . '/input.txt';
    }

    public function run() : void
    {
        $this->part1();
        $this->part2();
    }

    public function getInstructions() : array
    {
        $crates = [];
        $commands = [];
        $is_command = false;

        
        foreach ( $this->data  as $text ) {
            // Whitespace separating crates and commands
            if ( $text === "" ) {
                $is_command = true;
                continue;
            }

            // It's a command
            if ( $is_command ) {
                $commands[] = $text;
            }
            // It's a crate 
            else {
                // [Z] [M] [P] [Z] [M]
                // .1...5...9...
                foreach ( str_split($text) as $idx => $char ) {                    
                    if ( $char === " " ) {
                        continue;
                    }

                    if ( $idx % 4 - 1 !== 0 ) {
                        continue;
                    }

                    // Gross condition for the row with all numbers (crate positions)
                    if ( (int) $text !== 0 ) {
                        continue;
                    }

                    // Map for index to 
                    // 1 => 0
                    // 5 => 1
                    // 9 => 2
                    $crate_idx = $idx / 4 - 0.25;

                    if ( ! isset( $crates[$crate_idx] ) ) {
                        $crates[$crate_idx] = [];
                    }

                    $crates[$crate_idx][] = $char;
                }

                continue;
            }
        }

        return [ $crates, $commands ];
    }

    public function getFirstCrates(array $crates) : string
    {
        $first_crates = "";

        for( $i = 0; $i < count($crates); $i++ ) {
            if ( isset($crates[$i]) && ! empty($crates[$i]) ) {
                $first_crates .= $crates[$i][0];
            }
        }
        
        return $first_crates;
    }

    public function extractCommand(string $c) : array
    {
        [$move_count, $from_to] = array_map("trim", explode("from", $c));

        [$_, $move_count] = array_map(function($str) {
            return intval(trim($str));
        }, explode(" ", $move_count));

        [$from_idx, $to_idx] = array_map(function($str) {
            return intval(trim($str));
        }, explode("to", $from_to));

        return [ $from_idx, $to_idx, $move_count ];

    }

    public function part1() : void
    {
        [$crates, $commands] = $this->getInstructions();

        foreach ( $commands as $c ) {
            [$from_idx, $to_idx, $move_count] = $this->extractCommand($c);

            for( $i = 0; $i < $move_count; $i++ ) {
                array_unshift($crates[$to_idx - 1], array_shift($crates[$from_idx - 1]));
            }
        }

        $this->part1_answer = $this->getFirstCrates($crates);
    }

    public function part2() : void
    {
        [$crates, $commands] = $this->getInstructions();

        foreach ( $commands as $c ) {
            [$from_idx, $to_idx, $move_count] = $this->extractCommand($c);

            $move_items = [];

            for ( $i = 0; $i < $move_count; $i++ ) {
                if ( ! empty ($crates[$from_idx - 1 ] ) ) {
                    $move_items[] = array_shift($crates[$from_idx - 1]);
                }
            }

            for ( $i = count($move_items); $i > 0; $i-- ) {
                array_unshift($crates[$to_idx - 1], $move_items[$i - 1]);
            }
        }

        $this->part2_answer = $this->getFirstCrates($crates);
    }
}
