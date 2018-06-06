<?php
namespace hangman;

include_once 'Classes/Board.php';

$time = date('H') < 12 ? "morning" : "afternoon";

echo exec('clear');

echo "\n\n";
echo "\033[0;31m       OO   OO      OOO      OO   OO      OOOOO     OO    OO      OOO      OO   OO\033[0m\n";
echo "\033[0;31m       OO   OO     OO OO     OOO  OO     OO         OOO  OOO     OO OO     OOO  OO\033[0m\n";
echo "\033[0;31m       OOOOOOO    OOOOOOO    OO O OO    OO  OOO     OO OO OO    OOOOOOO    OO O OO\033[0m\n";
echo "\033[0;31m       OO   OO    OO   OO    OO  OOO     OO   OO    OO    OO    OO   OO    OO  OOO\033[0m\n";
echo "\033[0;31m       OO   OO    OO   OO    OO   OO      OOOOO     OO    OO    OO   OO    OO   OO\033[0m\n";

echo "\n\nGood " . $time . ". What is your name? ";

$playerNameHandle = fopen("php://stdin", "r");
$playerName = fgets($playerNameHandle);
fclose($playerNameHandle);

echo "\033[10;0H";
echo "Good " . $time . " " . trim($playerName) . ". Would you like to play hangman? ";

$playHandle = fopen("php://stdin", "r");
$play = fgets($playHandle);
if (substr(trim(strtolower($play)), 0, 1) != 'y') {
    echo "\033[10;0H\r\033[K";
    echo "Maybe next time.\n";
    exit;
}
fclose($playHandle);

echo "\033[10;0H\r\033[K";
echo "Great. Let's play!\n\n";
sleep(1);

$hangmanBoard = new classes\Board();
$badAttempts = 0;
$winner = false;

while ($badAttempts < 7 && !$winner) {
    echo "\033[10;0H\r\033[K";
    echo "Available letters: ";
    echo implode(", ", $hangmanBoard->getAvailableLetters()) . "\n";
    echo "Used letters: ";
    echo implode(", ", $hangmanBoard->getUsedLetters()) . "\n\n";

    echo $hangmanBoard->drawBoard($badAttempts);
    echo "\033[0;31m                         " . $hangmanBoard->getTiles() . "\033[0m";

    echo "\n\n\r\033[K";
    echo "Pick a letter: ";
    $letterHandle = fopen("php://stdin", "r");
    $chosenLetter = fgets($letterHandle);
    fclose($letterHandle);

    if (!$hangmanBoard->duplicateLetter(trim($chosenLetter))) {
        if ($hangmanBoard->checkLetter(trim($chosenLetter))) {
            echo "\r\033[K";
            echo "\nYes! " . trim($chosenLetter) . " was found in the word.\n\n";

            if ($hangmanBoard->hasWord()) {
                $winner = true;
            }
        } else {
            echo "\r\033[K";
            echo "\nSo sorry, " . trim($chosenLetter) . " was not found in the word.\n\n";
            $badAttempts++;
        }
    } else {
        echo "\r\033[K";
        echo "\nYou already guessed that letter. Try again.\n\n";
    }
}

echo "\033[10;0H\r\033[K";
echo "Available letters: ";
echo implode(", ", $hangmanBoard->getAvailableLetters()) . "\n";
echo "Used letters: ";
echo implode(", ", $hangmanBoard->getUsedLetters()) . "\n\n";
echo $hangmanBoard->drawBoard($badAttempts);
echo "\033[0;31m                         " . $hangmanBoard->getTiles() . "\033[0m";
echo "\n\n\r\033[K";
echo $winner ? "You Won! Great Job!\n" :
    "You Lose! The word was " . $hangmanBoard->getWord() . ". Better luck next time.\n";
echo "The word " . $hangmanBoard->getWord();
echo $hangmanBoard->getWordDefinition() === null ? " is not defined in the Oxford dictionary." :
    " is defined in the Oxford dictionary as: " . $hangmanBoard->getWordDefinition();
echo "\n\r\033[K\n";
