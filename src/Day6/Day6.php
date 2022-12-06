<?php

namespace AOC2022\Day6;

use AOC2022\BaseClass;

class Day6 extends BaseClass
{
    public static int $part_1_packet_length = 4;
    public static int $part_2_packet_length = 14;

    public function setupPath() : void
    {
        $this->file_path = __DIR__ . '/input.txt';
    }

    public function run() : void
    {
        $this->bothParts();
    }

    public function bothParts() : void
    {
        $signal = $this->data[0];
        $signal_chars = str_split($signal);

        foreach ( $signal_chars as $idx => $char ) {

            if ( $idx > self::$part_1_packet_length
                && ! $this->part1_answer ) {

                $sub_arr = array_slice($signal_chars, $idx - self::$part_1_packet_length, self::$part_1_packet_length);

                if ( count(array_unique($sub_arr)) === self::$part_1_packet_length ) {
                    $this->part1_answer = $idx;
                }
            }

            if ( $idx > self::$part_2_packet_length
                && ! $this->part2_answer ) {

                $sub_arr = array_slice($signal_chars, $idx - self::$part_2_packet_length, self::$part_2_packet_length);

                if ( count(array_unique($sub_arr)) === self::$part_2_packet_length ) {
                    $this->part2_answer = $idx;
                }
            }
        }
    }
}
