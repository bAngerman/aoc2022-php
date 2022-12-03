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

    public function getRuckSackError(string $item_1, string $item_2, string $item_3 = "") : string
    {
        $overlap = [];

        if ( $item_3 ) {
            $overlap = array_intersect(
                str_split($item_1),
                str_split($item_2),
                str_split($item_3)
            );            
        } else {
            $overlap = array_intersect(
                str_split($item_1),
                str_split($item_2)
            );
        }

        $overlap = array_values( 
            array_unique(
                $overlap
            )
        );

        if ( count($overlap) !== 1 ) {
            throw new \ErrorException("There was no overlap in the rucksack items");
        }

        return $overlap[0];
    }

    public function getPrioritySumForItem(string $char) : int
    {
        if ( ! $char ) {
            return 0;
        }

        $sum = ord(strtoupper($char)) - ord('A') + 1;

        if ( ctype_upper($char) ) {
            $sum += 26;
        }

        return $sum;
    }

    public function part1() : void
    {
        $priority_sum = 0;
        
        foreach ( $this->data as $packs ) {
            if ( strlen($packs) % 2 !== 0 ) {
                throw new \ErrorException("This pack does not have an even number of characters... so it is broken?");
            }

            $item_1 = substr($packs, 0, strlen($packs) / 2 );
            $item_2 = substr($packs, strlen($packs) / 2, strlen($packs));

            $common_item = $this->getRuckSackError($item_1, $item_2);

            $priority_sum += $this->getPrioritySumForItem($common_item);
        }

        $this->part1_answer = $priority_sum;
    }

    public function part2() : void
    {
        $idx = 0;
        $priority_sum = 0;
        while ( $idx < count( $this->data ) ) {
            // Grab 3 items, calculate priority sum for those three values, increment $idx

            $item_1 = $this->data[$idx];
            $item_2 = $this->data[$idx + 1];
            $item_3 = $this->data[$idx + 2];

            $common_item = $this->getRuckSackError($item_1, $item_2, $item_3);

            $priority_sum += $this->getPrioritySumForItem($common_item);

            // Move three positions in array.   
            $idx = $idx + 3;
        }

        $this->part2_answer = $priority_sum;
    }
}
