<?php
namespace hangman;

include_once 'classes/Hangman.php';

$time = date('H') < 12 ? "morning" : "afternoon";

echo exec('clear');

echo " OO   OO      OOO      OO   OO      OOOOO     OO    OO      OOO      OO   OO\n";
echo " OO   OO     OO OO     OOO  OO     OO         OOO  OOO     OO OO     OOO  OO\n";
echo " OOOOOOO    OOOOOOO    OO O OO    OO  OOO     OO OO OO    OOOOOOO    OO O OO\n";
echo " OO   OO    OO   OO    OO  OOO     OO   OO    OO    OO    OO   OO    OO  OOO\n";
echo " OO   OO    OO   OO    OO   OO      OOOOO     OO    OO    OO   OO    OO   OO\n";

echo "\n\nGood " . $time . ". What is your name? ";

$playerNameHandle = fopen("php://stdin", "r");
$playerName = fgets($playerNameHandle);
fclose($playerNameHandle);

echo "\nGood " . $time . " " . trim($playerName) . ". Would you like to play hangman? ";

$playHandle = fopen("php://stdin", "r");
$play = fgets($playHandle);
if (substr(trim(strtolower($play)), 0, 1) != 'y') {
    echo "\nMaybe next time.\n";
    exit;
}
fclose($playHandle);

echo "\n";
echo "Great. Let's play!\n\n";

$hangman = new classes\Hangman();
$badAttempts = 0;
$winner = false;

while ($badAttempts < 7 && !$winner) {
    echo "Your available letters are: \n";
    echo implode(", ", $hangman->getAvailableLetters()) . "\n\n";

    echo $hangman->drawBoard($badAttempts);
    echo $hangman->getTiles();

    echo "\n\nPick a letter: ";
    $letterHandle = fopen("php://stdin", "r");
    $chosenLetter = fgets($letterHandle);
    fclose($letterHandle);

    if (!$hangman->duplicateLetter(trim($chosenLetter))) {
        if ($hangman->checkLetter(trim($chosenLetter))) {
            echo "\nYes! " . trim($chosenLetter) . " was found in the word.\n\n";

            if ($hangman->hasWord()) {
                $winner = true;
            }
        } else {
            echo "\nSo sorry, " . trim($chosenLetter) . " was not found in the word.\n\n";
            $badAttempts++;
        }
    } else {
        echo "\nYou already guessed that letter. Try again.\n\n";
    }
}

if ($winner) {
    echo $hangman->drawBoard($badAttempts);
    echo $hangman->getTiles();
    echo "\n\nYou Won!!\n\n";
} else {
    echo $hangman->drawBoard($badAttempts);
    echo $hangman->getTiles();
    echo "\n\nYou Lose! Better luck next time.\n\n";
}