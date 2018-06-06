<?php
namespace hangman\Classes;

include_once '../words_alpha.txt';

class RandomWord
{
    /**
     * @var string
     */
    private $word;

    public function __construct()
    {
        $this->setRandomWord();
    }

    private function setRandomWord()
    {
        $file = "words_alpha.txt";
        $file_arr = file($file);
        $num_lines = count($file_arr);
        $last_arr_index = $num_lines - 1;
        $rand_index = rand(0, $last_arr_index);
        $rand_text = $file_arr[$rand_index];

        $this->word = trim($rand_text);
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
