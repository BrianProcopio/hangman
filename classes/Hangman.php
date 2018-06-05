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

    public function getTiles($usedLetters = null)
    {
        $tiles = [];
        $tileCount = strlen($this->getWord());
        $correctLetters = [];

        for ($i = 0; $i < $tileCount; $i++) {
            $i+1 === $tileCount ? $tiles[] = "_" : $tiles[] = "_ ";
        }

        if (!empty($this->getUsedLetters())) {
            foreach ($usedLetters as $usedLetter) {
                $hasLetter = true;
                $positions = [];
                while ($hasLetter === true) {
                    $y = empty($positions) ? 0 : end($positions);
                    $pos = stripos($usedLetter, $this->getWord(), $y);
                    if ($pos !== false) {
                        $correctLetters[$usedLetter] = $pos;
                        $positions[] = $pos;
                    } else {
                        $hasLetter = false;
                    }
                }
            }
        }

        return implode($tiles);
    }

    public function getAvailableLetters()
    {
        return $this->availableLetters;
    }

    public function getUsedLetters()
    {
        return $this->usedLetters;
    }

    public function drawBoard()
    {
        return "\n \n";
    }
}