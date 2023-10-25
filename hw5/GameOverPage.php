<?php
if (empty($_SESSION["email"]))
    header("Location: index.php");

if (empty($_SESSION["name"]))
    header("Location: index.php");
?>

<!DOCTYPE html>

<!-- This template will display the list of categories and their words, the number of guesses
it took to select all categories correctly (if they were successful), and provide the option for the user to play again or exit.
If the user chooses to play again, return them to the game page with a new set of words (from new categories).
If the user chooses to exit, destroy the current session and display the welcome page again. -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Game Over</title>
    <link rel="stylesheet" href="GameOverPage.css">
</head>
<body>
<main>
    <h1 class="heading"> Game Over!</h1>

    <?php

    $num_of_guesses = $_SESSION["num_of_guesses"];

    $name = $_SESSION['name'];


    if (empty($_SESSION["shuffledWords"])) {

        echo "<h2 class='heading' > Congratulations $name !</h2>";

        echo "<h3 class='heading'> It took you $num_of_guesses guesses to select all categories correctly </h3>" ;

        //$ansDict = ["A" => ["hey", "hello", "whats up", "hi"], "B" => ["giraffe", "Elephant", "Tiger", "Lion"], "C" => ["bye", "goodbye", "adios", "see ya later"], "D" => ["sushi", "hamburger", "lettuce", "carrots"]];

        // ansdict is a dict of category and array of word
        echo "<div class='container'>";

    }

    else {

        echo "<h2 class='heading' > Sorry $name, You didn't solve connections !</h2>";

        echo "<h3 class='heading'> You took $num_of_guesses guesses to select all categories correctly </h3>" ;
        echo "<h3 class='heading'> Here are the solutions anyway </h3>";
        echo "<div class='container'>";

    }

    $int = 1;

    $ansDict = $_SESSION['ansDict'];


    foreach($ansDict as $cat => $words) {

        echo "<div  id=c$int class='answers'>";
        echo "<h2> $cat </h1>";
        echo "<ol>";

        $int += 1;

        foreach($words as $word) {
            echo $word."<br>";
        }
        echo "</ol></div>";

    }

    echo "</div>";

    ?>

    <form action="?command=playAgain" method="post">
        <input type="submit" value="Play Again">
    </form>

    <form action="?command=quit" method="post">
        <input type="submit" value="Quit">
    </form>

</main>
<!--<script src="index.js"></script>-->
</body>
</html>