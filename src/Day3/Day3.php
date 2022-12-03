<?php

namespace AOC2022\Day3;

use AOC2022\BaseClass;

class Day3 extends BaseClass
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
        foreach ( $this->data as $packs ) {
            if ( strlen($packs) % 2 !== 0 ) {
                throw new \ErrorException("This pack does not have an even number of characters... so it is broken?");
            }

            $item_1 = substr($packs, 0, strlen($packs) / 2 );
            $item_2 = substr($packs, strlen($packs) / 2, strlen($packs));

            dd( $item_1, $item_2 );
        }
    }

    public function part2() : void
    {
        
    }
}
