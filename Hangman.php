<?php
namespace hangman;

include_once 'Classes/Board.php';

$time = date('H') < 12 ? "morning" : "afternoon";

echo exec('clear');

echo "\n\n";
echo "\e[0;31m       OO   OO      OOO      OO   OO      OOOOO     OO    OO      OOO      OO   OO\e[0m\n";
echo "\e[0;31m       OO   OO     OO OO     OOO  OO     OO         OOO  OOO     OO OO     OOO  OO\e[0m\n";
echo "\e[0;31m       OOOOOOO    OOOOOOO    OO O OO    OO  OOO     OO OO OO    OOOOOOO    OO O OO\e[0m\n";
echo "\e[0;31m       OO   OO    OO   OO    OO  OOO     OO   OO    OO    OO    OO   OO    OO  OOO\e[0m\n";
echo "\e[0;31m       OO   OO    OO   OO    OO   OO      OOOOO     OO    OO    OO   OO    OO   OO\e[0m\n";

echo "\n\nGood " . $time . ". What is your name? ";

$playerNameHandle = fopen("php://stdin", "r");
$playerName = fgets($playerNameHandle);
fclose($playerNameHandle);

echo "\e[10;0H";
echo "Good " . $time . " " . trim($playerName) . ". Would you like to play hangman? ";

$playHandle = fopen("php://stdin", "r");
$play = fgets($playHandle);
if (substr(trim(strtolower($play)), 0, 1) != 'y') {
    echo "\e[10;0H\r\e[K";
    echo "Maybe next time.\n";
    exit;
}
fclose($playHandle);

echo "\e[10;0H\r\e[K";
echo "Great. Let's play!\n\n";
sleep(1);

$hangmanBoard = new classes\Board();
$badAttempts = 0;
$winner = false;

while ($badAttempts < 7 && !$winner) {
    echo "\e[10;0H\r\e[K";
    echo "Available letters: ";
    echo implode(", ", $hangmanBoard->getAvailableLetters()) . "\n";
    echo "Used letters: ";
    echo implode(", ", $hangmanBoard->getUsedLetters()) . "\n\n";

    echo $hangmanBoard->drawBoard($badAttempts);
    echo "\e[0;31m                         " . $hangmanBoard->getTiles() . "\e[0m";

    echo "\n\n\r\e[K";
    echo "Pick a letter: ";
    $letterHandle = fopen("php://stdin", "r");
    $chosenLetter = fgets($letterHandle);
    fclose($letterHandle);

    if (!$hangmanBoard->validLetter(trim($chosenLetter))) {
        echo "\r\e[K";
        echo "\nPlease enter a single valid alphabetic character.\n\n";
    } elseif (!$hangmanBoard->duplicateLetter(trim($chosenLetter))) {
        if ($hangmanBoard->checkLetter(trim($chosenLetter))) {
            echo "\r\e[K";
            echo "\nYes! " . trim($chosenLetter) . " was found in the word.\n\n";

            if ($hangmanBoard->hasWord()) {
                $winner = true;
            }
        } else {
            echo "\r\e[K";
            echo "\nSo sorry, " . trim($chosenLetter) . " was not found in the word.\n\n";
            $badAttempts++;
        }
    } else {
        echo "\r\e[K";
        echo "\nYou already guessed that letter. Try again.\n\n";
    }
}

echo "\e[10;0H\r\e[K";
echo "Available letters: ";
echo implode(", ", $hangmanBoard->getAvailableLetters()) . "\n";
echo "Used letters: ";
echo implode(", ", $hangmanBoard->getUsedLetters()) . "\n\n";
echo $hangmanBoard->drawBoard($badAttempts);
echo "\e[0;31m                         " . $hangmanBoard->getTiles() . "\e[0m";
echo "\n\n\r\e[K";
echo $winner ? "You Won! Great Job!\n" :
    "You Lose! The word was \e[1;31m" . $hangmanBoard->getWord() . "\e[0m. Better luck next time.\n";
echo "The word \e[1;31m" . $hangmanBoard->getWord() . "\e[0m";
echo $hangmanBoard->getWordDefinition() === null ? " is not defined in the Oxford dictionary." :
    " is defined in the Oxford dictionary as: \"\e[0;34m" . $hangmanBoard->getWordDefinition() . "\e[0m\".";
echo "\n\r\e[K\n";
