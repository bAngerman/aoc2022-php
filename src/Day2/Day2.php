<?php

namespace AOC2022\Day2;

use AOC2022\BaseClass;
use ErrorException;

class Day2 extends BaseClass
{

    protected static array $draw_map = [
        "A" => "X",
        "B" => "Y",
        "C" => "Z",
    ];

    protected static array $win_map = [
        "C" => "X",
        "A" => "Y",
        "B" => "Z"
    ];

    // X (Rock) beats C (Scissors)
    // Y (Paper) beats A (Rock)
    // Z (Scissors) beats B (Paper)
    protected static array $lose_map = [
        "C" => "Y",
        "B" => "X",
        "A" => "Z"
    ];

    public function setupPath() : void
    {
        $this->file_path = __DIR__ . '/input.txt';
    }

    public function run() : void
    {
        $this->part1();
        $this->part2();
    }

    public function getShapeScore(string $command) : int
    {
        $score = 0;

        switch($command) {
            case "A":
            case "X":
                $score = 1;
                break;

            case "B":
            case "Y":
                $score = 2;
                break;
            
            case "C":
            case "Z":
                $score = 3;
                break;
        }

        return $score;
    }

    public function getGameScore($opp_move, $my_move) : int
    {
        // X (Rock) beats C (Scissors)
        // Y (Paper) beats A (Rock)
        // Z (Scissors) beats B (Paper)

        // Check if draw and return early.
        if ( self::$draw_map[$opp_move] === $my_move ) {
            return 3;
        }

        // Check if it's a win.
        if ( self::$win_map[$opp_move] === $my_move ) {
            return 6;
        }

        // It's a loss.
        return 0;
    }

    public function part1() : void
    {
        // A -> Rock
        // B -> Paper
        // C -> Scissors

        // X -> Rock
        // Y -> Paper
        // Z -> Scissors

        $score = 0;

        foreach ( $this->data as $game ) {
            [$opp_move, $my_move] = explode(" ", $game);

            // Add to score based on shape used (Rock, Paper, Scissors)
            $score += $this->getShapeScore($my_move); 
            
            // Determine winner of the game.
            $score += $this->getGameScore($opp_move, $my_move);
        }

        $this->part1_answer = $score;
    }

    public function getAlternateMove($opp_move, $desired_outcome) : string
    {
        // Desired outcome
        // X -> Lose
        // Y -> Draw
        // Z -> Win

        if ( $desired_outcome === "Y" ) {
            return self::$draw_map[$opp_move];
        }

        if ( $desired_outcome === "Z" ) {
            return self::$win_map[$opp_move];
        }

        if ( $desired_outcome === "X" ) {
            return self::$lose_map[$opp_move];
        }

        throw new ErrorException("Something went wrong getting the alternate move, desired outcome: ", $desired_outcome);
    }

    public function part2() : void
    {
        $score = 0;

        foreach ( $this->data as $game ) {
            [$opp_move, $my_move] = explode(" ", $game);

            $alt_move = $this->getAlternateMove($opp_move, $my_move);

            // dd( $alt_move, $opp_move, $my_move );

            // Add to score based on shape used (Rock, Paper, Scissors)
            $score += $this->getShapeScore($alt_move);
            
            // Determine winner of the game.
            $score += $this->getGameScore($opp_move, $alt_move);
        }

        $this->part2_answer = $score;
    }
}
