<?php
namespace hangman\Classes;

include_once '../word_list.txt';

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
        $file = "word_list.txt";
        $file_arr = file($file);
        $num_lines = count($file_arr);
        $last_arr_index = $num_lines - 1;
        $rand_index = rand(0, $last_arr_index);
        $rand_text = $file_arr[$rand_index];

        if (strlen(trim($rand_text)) < 4) {
            $this->setRandomWord();
        }

        $this->word = trim($rand_text);
    }

    public function getWord()
    {
        return $this->word;
    }

    public function getDefinition()
    {
        $url = "https://od-api.oxforddictionaries.com/api/v1/entries/en/" . strtolower($this->getWord());
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['app_id: d07c8c10', 'app_key: 92913385eab4970e740b6a4b1d58d17f']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        $senses = $response['results'][0]['lexicalEntries'][0]['entries'][0]['senses'][0];

        return isset($senses['definitions']) ? $senses['definitions'][0] : $senses['crossReferenceMarkers'][0];
    }

    public function __toString()
    {
        return $this->getWord();
    }
}
