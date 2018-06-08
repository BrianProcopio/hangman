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
        $rand_text = trim($file_arr[$rand_index]);

        strlen($rand_text) < 4 ? $this->setRandomWord() : $this->word = $rand_text;
    }

    public function getWord()
    {
        return $this->word;
    }

    public function getDefinition($word = null)
    {
        if ($word !== null) {
            $url = "https://od-api.oxforddictionaries.com/api/v1/entries/en/" . strtolower($word);
            $ch = curl_init($url);
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                ['app_id: d07c8c10', 'app_key: 92913385eab4970e740b6a4b1d58d17f']
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            $senses = $response['results'][0]['lexicalEntries'][0]['entries'][0]['senses'][0];

            if (isset($senses['definitions'])) {
                return $senses['definitions'][0];
            } elseif (isset($senses['crossReferenceMarkers'])) {
                return $senses['crossReferenceMarkers'][0];
            } else {
                return $this->getDefinition($this->getInflection($word));
            }
        }

        return $word;
    }

    public function getInflection($word)
    {
        $url = "https://od-api.oxforddictionaries.com/api/v1/inflections/en/" . strtolower($word);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['app_id: d07c8c10', 'app_key: 92913385eab4970e740b6a4b1d58d17f']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        return $response['results'][0]['lexicalEntries'][0]['inflectionOf'][0]['text'];
    }

    public function __toString()
    {
        return $this->getWord();
    }
}
