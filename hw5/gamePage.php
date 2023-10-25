<?php
if (empty($_SESSION["email"]))
    header("Location: index.php");

if (empty($_SESSION["name"]))
    header("Location: index.php");
    ?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="CS4640 Fall 2023">
    <meta name="description" content="An example PHP Form page">
    <title>Connections</title>
</head>

<body>
<h1 style="text-align: center;">
    Connections
</h1>

<h2 style="text-align: center;">
Below is a grid of words<br>
In total, there are 4 categories <br>
In the grid, there are 4 words for each category<br>
To take a guess, select 4 words from the grid that you think are related by a category<br>
Enter you guesses by entering the numbers associated with each word seperated by a space<br>
for example, "1 2 3 4"
</h2>
    <br>
    <form style="text-align: center;" action="?command=gamePage" method="post">
        <label>
            <input type="text" name="numbers">
        </label>
        <input type="submit" value="Submit">
    </form>

    <form style="text-align: center;" action="?command=gameOver" method="post">
        <input type="submit" value="Quit"> <br> <br>
    </form>

</body>

</html>




