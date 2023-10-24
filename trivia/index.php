<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

//spl_autoload_register(function ($classname) {
//    include "$classname.php";
//});

include "TriviaController.php";

if(!isset($_SESSION)) {
    session_start();
}

if(!$_SESSION["trivia"]) {
    $trivia = new TriviaController($_GET);
    $_SESSION["trivia"] = $trivia;
    $trivia->run();
}
else {
    $trivia = $_SESSION["trivia"];
//    $trivia->setInput($_GET);
    $trivia->run();
}
$trivia->run();

