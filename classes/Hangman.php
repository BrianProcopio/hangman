<?php

namespace hangman\classes;

include_once 'RandomWord.php';

class Hangman
{
    /**
     * @var RandomWord
     */
    private $randomWord;

    /**
     * @var array
     */
    private $availableLetters;

    /**
     * @var array
     */
    private $usedLetters;

    public function __construct()
    {
        $this->usedLetters = [];
        $this->availableLetters = range('a', 'z');
        $this->randomWord = new RandomWord();
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->randomWord->getWord();
    }

    public function getTiles()
    {
        $tiles = [];
        $tileCount = strlen($this->getWord());
        $correctLetters = [];

        for ($i = 0; $i < $tileCount; $i++) {
            $i+1 === $tileCount ? $tiles[] = "_" : $tiles[] = "_ ";
        }

        foreach ($this->getUsedLetters() as $usedLetter) {
            $positions = [];
            $hasLetter = true;
            while ($hasLetter === true) {
                $pos = empty($positions) ? stripos($this->getWord(), $usedLetter) :
                    stripos($this->getWord(), $usedLetter, end($positions)+1);
                if ($pos !== false) {
                    $correctLetters[$usedLetter][] = $pos;
                    $positions[] = $pos;
                } else {
                    $hasLetter = false;
                }
            }
        }

        foreach ($correctLetters as $key => $val) {
            foreach ($val as $tilePosition) {
                $tiles[$tilePosition] = $key . " ";
            }
        }

        return implode($tiles);
    }

    public function getAvailableLetters()
    {
        return array_diff($this->availableLetters, $this->usedLetters);
    }

    public function hasWord()
    {
        $correctLetterCount = 0;

        foreach ($this->getUsedLetters() as $usedLetter) {
            $positions = [];
            $hasLetter = true;
            while ($hasLetter === true) {
                $pos = empty($positions) ? stripos($this->getWord(), $usedLetter) :
                    stripos($this->getWord(), $usedLetter, end($positions)+1);
                if ($pos !== false) {
                    $positions[] = $pos;
                    $correctLetterCount++;
                } else {
                    $hasLetter = false;
                }
            }
        }

        return $correctLetterCount === strlen($this->getWord());
    }

    public function checkLetter($letter) {
        $this->usedLetters[] = strtolower($letter);
        return stripos($this->getWord(), $letter) !== false;
    }

    public function duplicateLetter($letter) {
        return in_array($letter, $this->usedLetters);
    }

    public function getUsedLetters()
    {
        return $this->usedLetters;
    }

    public function drawBoard($badAttempts)
    {
        $string  = " __          \n";
        $string .= " ||==========\n";
        $string .= " || //      |\n";

        switch ($badAttempts) {
            case 0:
                $string .= " ||//\n";
                $string .= " ||\n";
                $string .= " ||\n";
                $string .= " ||\n";
                break;
            case 1:
                $string .= " ||//       O\n";
                $string .= " ||\n";
                $string .= " ||\n";
                $string .= " ||\n";
                break;
            case 2:
                $string .= " ||//       O\n";
                $string .= " ||         |\n";
                $string .= " ||\n";
                $string .= " ||\n";
                break;
            case 3:
                $string .= " ||//       O\n";
                $string .= " ||       --|\n";
                $string .= " ||\n";
                $string .= " ||\n";
                break;
            case 4:
                $string .= " ||//       O\n";
                $string .= " ||       --|--\n";
                $string .= " ||\n";
                $string .= " ||\n";
                break;
            case 5:
                $string .= " ||//       O\n";
                $string .= " ||       --|--\n";
                $string .= " ||         |\n";
                $string .= " ||\n";
                break;
            case 6:
                $string .= " ||//       O\n";
                $string .= " ||       --|--\n";
                $string .= " ||         |\n";
                $string .= " ||        /\n";
                break;
            default:
                $string .= " ||//       O\n";
                $string .= " ||       --|--\n";
                $string .= " ||         |\n";
                $string .= " ||        / \\\n";
        }

        $string .= "––––         \n\n";

        return $string;
    }
}