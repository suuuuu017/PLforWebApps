<?php
// REQUIRED HEADERS FOR CORS
// Allow access to our development server, localhost:4200
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");

$json = file_get_contents("php://input");
$input = json_decode($json, true);

$wordlist = file("http://ford.cs.virginia.edu/cs4640-wordlist.txt");
$word = $wordlist[rand(0, count($wordlist) - 1)];
$word = trim($word);


header("Content-Type: application/json");
echo json_encode($word, JSON_PRETTY_PRINT);
