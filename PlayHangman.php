<?php
namespace hangman;

include_once 'classes/Hangman.php';

$time = date('H') < 12 ? "morning" : "afternoon";

echo "\n" . "Good " . $time . ". What is your name? ";

$playerNameHandle = fopen("php://stdin", "r");
$playerName = fgets($playerNameHandle);
fclose($playerNameHandle);

echo "Good " . $time . " " . trim($playerName) . ". Would you like to play hangman? ";

$playBlackjackHandle = fopen("php://stdin", "r");
$playBlackjack = fgets($playBlackjackHandle);
if (substr(trim(strtolower($playBlackjack)), 0, 1) != 'y') {
    echo "\nMaybe next time.\n";
    exit;
}
fclose($playBlackjackHandle);

echo "\n";
echo "Great. Let's play!\n\n";

$hangman = new classes\Hangman();
$endGame = false;

echo "Your available letters are: \n";
echo implode(", ", $hangman->getAvailableLetters()) . "\n\n";
echo $hangman->drawBoard();
echo $hangman->getTiles();
$letterHandle = fopen("php://stdin", "r");
$chosenLetter = fgets($letterHandle);

echo "\n\nPick a letter \n";