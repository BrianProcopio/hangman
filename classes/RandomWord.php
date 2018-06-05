<?php
namespace hangman\classes;

class RandomWord
{
    /**
     * @var string
     */
    private $word;

    public function __construct()
    {
        $this->word = "Surrender";
    }

    public function getWord()
    {
        return $this->word;
    }

    public function __toString()
    {
        return $this->getWord();
    }
}
