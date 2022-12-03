<?php

namespace AOC2022\Day1;

use AOC2022\BaseClass;

class Day1 extends BaseClass
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
        $this->answer_data = [];
        $elf_index = 0;

        foreach( $this->data as $item ) {
            if ( $item === "" ) {
                $elf_index++;
                continue;
            }

            if ( ! isset( $this->answer_data[$elf_index] ) ) {
                $this->answer_data[$elf_index] = 0;
            }

            $this->answer_data[$elf_index] = $this->answer_data[$elf_index] + $item;
        }

        rsort($this->answer_data);
        $this->part1_answer = $this->answer_data[0];

        return;
    }

    public function part2() : void
    {
        $this->part2_answer = array_sum(array_slice($this->answer_data, 0, 3));
    }
}
