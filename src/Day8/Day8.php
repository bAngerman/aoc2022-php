<?php

namespace AOC2022\Day8;

use AOC2022\BaseClass;

class Day8 extends BaseClass
{
    public array $trees = [];

    public function setupPath() : void
    {
        $this->file_path = __DIR__ . '/input.txt';
    }

    public function run() : void
    {
        $this->setupTrees();
        $this->part1();
        $this->part2();
    }

    public function setupTrees() : void
    {
        $this->trees = array_map(function($row) {
            return str_split($row);
        }, $this->data);
    }

    public function checkVisiblity(string $dir, int $x, int $y, int $tree_height) : array
    {
        $x_pos = $x;
        $y_pos = $y;
        $visible = false;

        while ( true ) {
            switch ( $dir ) {
                case 'left':
                    $x_pos = $x_pos - 1;
                    break;
                case 'top' :
                    $y_pos = $y_pos - 1;
                    break;
                case 'right':
                    $x_pos = $x_pos + 1;
                    break;
                case 'bottom':
                    $y_pos = $y_pos + 1;
                    break;
            }

            if ( ! isset( $this->trees[$y_pos][$x_pos] ) ) {
                // Outside edge boundary, so it is visible!
                $visible = true;
                switch ( $dir ) {
                    case 'left':
                        $x_pos = $x_pos + 1;
                        break;
                    case 'top' :
                        $y_pos = $y_pos + 1;
                        break;
                    case 'right':
                        $x_pos = $x_pos - 1;
                        break;
                    case 'bottom':
                        $y_pos = $y_pos - 1;
                        break;
                }
                break;
            }

            // Check if this tree is blocked by the tree
            if ( $tree_height <= $this->trees[$y_pos][$x_pos] ) {
                // dump( $tree_height . " (" .$y. "," .$x. ") is blocked by " . $this->trees[$y_pos][$x_pos] . " (" .$y_pos. "," .$x_pos. ") in the in the direction: " . $dir );
                break;
            }
        }
        
        return [$visible, $y_pos, $x_pos];
    }

    public function part1() : void
    {
        $visible_trees = 0;

        foreach ( $this->trees as $y => $row ) {
            foreach ( $row as $x => $tree ) {
                // Edge of trees, all visible.
                if ( $y === 0
                    || $y === count($this->trees) - 1
                    || $x === 0
                    || $x === count($row) - 1
                ) {
                    $visible_trees ++;
                    continue;
                }

                foreach( ['left', 'top', 'right', 'bottom'] as $dir ) {
                    [$visible, $y_pos, $x_pos] = $this->checkVisiblity($dir, $x, $y, $tree);
                    if ( $visible ) {
                        $visible_trees++;
                        continue 2;
                    }
                }
            }
        }

        $this->part1_answer = $visible_trees;
    }

    public function part2() : void
    {
        $scores = [];

        foreach ( $this->trees as $y => $row ) {
            foreach ( $row as $x => $tree ) {

                // Tree is on edge and has a score of 0.
                if ( $y === 0
                    || $y === count($this->trees) - 1
                    || $x === 0
                    || $x === count($row) - 1
                ) {
                    // dump("Skipping " . $tree);
                    continue;
                }
                
                $direction_scores = [];

                foreach( ['left', 'top', 'right', 'bottom'] as $dir ) {
                    [$visible, $y_pos, $x_pos] = $this->checkVisiblity($dir, $x, $y, $tree);
                    $direction_scores[$dir] = abs($y_pos - $y) + abs($x_pos - $x);
                }

                $visibility_score = $direction_scores['left'] 
                    * $direction_scores['top'] 
                    * $direction_scores['right'] 
                    * $direction_scores['bottom'];

                $scores[$visibility_score] = true;
            }
        }

        $this->part2_answer = max(array_keys($scores));
    }
}
