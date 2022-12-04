<?php

namespace AOC2022\Day4;

use AOC2022\BaseClass;

class Day4 extends BaseClass
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

    public function part1() : void
    {
        $overlap_count = 0;

        foreach ( $this->data as $line ) {
            [ $item_1, $item_2 ] = explode(",", $line);
            [ $item_1_start, $item_1_end ] = array_map('intval', explode("-", $item_1));
            [ $item_2_start, $item_2_end ] = array_map('intval', explode("-", $item_2));

            // If Item 1 is entirely within Item 2.
            // Eg:
            // .....6...  6-6
            // ...456...  4-6
            if ( $item_1_start >= $item_2_start 
                && $item_1_end <= $item_2_end
            ) {
                // dump( "Overlap", $item_1_start, $item_1_end, $item_2_start, $item_2_end );
                $overlap_count += 1;

                // Prevent double counting this with the next condition. This happens when the assignment are identical.
                continue; 
            }

            // If Item 2 is entirely within Item 1.
            // Eg:
            // .2345678.  2-8
            // ..34567..  3-7
            if ( $item_2_start >= $item_1_start
                && $item_2_end <= $item_1_end
            ) {
                // dump( "Overlap", $item_1_start, $item_1_end, $item_2_start, $item_2_end );
                $overlap_count += 1;
                continue;
            }
        }

        $this->part1_answer = $overlap_count;
    }

    public function part2() : void
    {
        $overlap_count = 0;

        foreach ( $this->data as $line ) {
            [ $item_1, $item_2 ] = explode(",", $line);
            [ $item_1_start, $item_1_end ] = array_map('intval', explode("-", $item_1));
            [ $item_2_start, $item_2_end ] = array_map('intval', explode("-", $item_2));

            if ( $item_1_start >= $item_2_start 
                && $item_2_end >= $item_1_start
            ) {
                $overlap_count += 1;
                continue;
            }

            if ( $item_2_start >= $item_1_start 
                && $item_1_end >= $item_2_start
            ) {
                $overlap_count += 1;
                continue;
            }

        }

        $this->part2_answer = $overlap_count;
    }
}
