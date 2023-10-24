<?php

class TriviaController {
//
//    private $questions = [];
//
    private $input = [];
    private $randomData = [];

    /**
     * Constructor
     */
    public function __construct($input) {


        $this->input = $input;
        $this->loadWords();
        echo "<script>console.log('oh no ');</script>";    }

    /**
     * Load questions from a URL, store them as an array
     * in the current object.
     */
    public function loadWords() {
        $categories = file_get_contents('categories.json');
        $allData = json_decode($categories, true);

        $randomIdx = array_rand($allData, 4);
        $randomData= array();
        foreach($randomIdx as $rI) {
            array_push($randomData, $allData[$rI]);
        }

        if (empty($randomData)) {
            die("Something went wrong loading data");
        }

        $_SESSION["randomData"] = $randomData;
        $this->randomData = $randomData;

        echo "i am here agian again ";

    }


    public function getWords() {

        $randomData = $_SESSION["randomData"];
        if ($randomData != null) {
            $ansCatAll = array();
            $ansWordsAll = array();

            $printingWords = array();
            $ansDict = array();
            $_SESSION["ansDict"] = $ansDict;
            foreach ($randomData as $rD) {
                $ansCat = $rD["category"];
                array_push($ansCatAll, $ansCat);
                $ansWords = $rD["words"];
                array_push($ansWordsAll, $ansWords);
                $ansDict[$ansCat] = $ansWords;

                foreach ($ansWords as $aW) {
                    array_push($printingWords, $aW);
                }
            }
            $_SESSION["ansDict"] = $ansDict;

            $index = 1;
            shuffle($printingWords);
            $shuffledWords = array();
            $_SESSION["shuffledWords"] = $shuffledWords;
            foreach ($printingWords as $pW) {
                echo "$index : ";
                echo "<button type=\"button\" > $pW </button>";
                if ($index % 4 == 0) {
                    echo "<br>";
                }
                $shuffledWords[$index] = $pW;
                $index = $index + 1;
            }
            $_SESSION["shuffledWords"] = $shuffledWords;
            echo "<br>";
        }
    }

    public function run() {
        // Get the command
        $command = "welcome";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch($command) {
            case "login":
                $this->login();
            case "question":
                $this->showWords();
                break;
            case "answer":
                echo session_id();
                $this->answerQuestion();
                print_r($_SESSION["randomData"]);
                $this->showWords();
                break;
            case "logout":
                $this->logout();
            default:
                $this->showWelcome();
                break;
        }
    }

    /**
     * Show a question to the user.  This function loads a
     * template PHP file and displays it to the user based on
     * properties of this object.
     */
    public function showWords($message = "") {
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $score = $_SESSION["score"];
        $this->getWords();
        include("./templates/question.php");
    }

    /**
     * Show the welcome page to the user.
     */
    public function showWelcome() {
        include("./templates/welcome.php");
    }

    /**
     * Check the user's answer to a question.
     */
    public function answerQuestion() {
//        $name = $_SESSION["name"];
//        $email = $_SESSION["email"];
//        $score = $_SESSION["score"];
//        include("./templates/question.php");

        echo "<br>";

        // TODO: warning when no user input
        $numbers = explode(" ", $_POST["numbers"]);
//        print_r($numbers);

        // find all the words corresponding to the number input by the user
        $chosenWords = array();
        foreach ($numbers as $n) {
            array_push($chosenWords,  $_SESSION["shuffledWords"][$n]);
        }
//        print_r($chosenWords);

        // find if the chosenwords all belong to one category
        // categorydict is a dict of category and array of word
        // count how many words are in the same category

        $ifSameCatDict = array();
        foreach ($chosenWords as $cW) {
            foreach ($_SESSION["ansDict"] as $cat => $words) {
                if (in_array($cW, $words)) {
                    if (array_key_exists($cat, $ifSameCatDict) == false) {
                        $ifSameCatDict[$cat] = 1;
                    } else {
                        $ifSameCatDict[$cat] = $ifSameCatDict[$cat] + 1;
                    }
                }
            }
        }

        print_r($ifSameCatDict);

        echo "<br>";

        // TODO: if user put in the same number multiple times
        $maxSame = max($ifSameCatDict);
        if ($maxSame == 4) {
            echo "You win!";
        }
        if ($maxSame == 3) {
            echo "You are almost there!";
        }
        if ($maxSame == 2) {
            echo "You are half way there!";
        } else {
            echo "Keep trying!";
        }
    }

    /**
     * Handle user registration and log-in
     */
    public function login() {

        if(isset($_POST["fullname"])) {
            $_SESSION["name"] = $_POST["fullname"];
        }

        if(isset($_POST["email"])) {
            $_SESSION["email"] = $_POST["email"];
        }

        $_SESSION["score"] = 0;

    }

    /**
     * Log out the user
     */
    public function logout() {
        session_destroy();

        session_start();
    }

}
