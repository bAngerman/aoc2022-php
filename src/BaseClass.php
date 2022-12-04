<?php

namespace AOC2022;

class BaseClass
{
    public array $answer_data = [];
    public $part1_answer;
    public $part2_answer;
    public array $data = [];
    public string $file_path;

    private null|AOCPerformance $performance = null;

    public function __construct($with_performance = false)
    {
        $this->setupPath();
        $this->setup();

        if ( $with_performance ) {
            $this->performance = (new AOCPerformance);
        }
    }
    
    public function __destruct() {
        dump( "Part 1 Answer:", $this->part1_answer );
        dump( "Part 2 Answer:", $this->part2_answer );

        if ( $this->performance ) {
            $this->performance->end();
        } 
    }

    public function setupPath() : void
    {
        // 
    }

    public function setup() : void
    {
        $f = file_get_contents($this->file_path);

        $f = explode("\r\n", $f);        

        $this->data = $f;

        return;
    }
}
