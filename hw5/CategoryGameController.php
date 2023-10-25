<?php


class CategoryGameController {

    private $input = [];
    private $randomData = [];

    /**
     * Constructor
     */
    public function __construct($input){
        session_start();
        $this->input = $input;
    }

    public function run() {

        $command = "welcome";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch ($command) {

            case "login":
                $this->login();
            
            case "gamePage":
                $this->showGamePage();
                $this->printWords();
                $this->checkAnswer();
                $this->printInfo();
                if(empty($_SESSION["shuffledWords"])){
                    ob_end_clean();
                    $this->showGameOverPage();
                    return;
                }
                ob_end_clean();
                $this->showGamePage();
                $this->printWords();
                echo $_SESSION["history"];
                $this->printInfo();
                break;
            case "logout":
                $this->logout();
//                break;

            case "playAgain":
                $this->loadWords();
                $this->showGamePage();
                $this->printWords();
                unset($_SESSION["history"]);
                $_SESSION["num_of_guesses"] = 0;
                $this->printInfo();

//                $this->logout();
                break;

            case "quit":
                $this->logout();
//                break;

            case "gameOver":
                $this->showGameOverPage();
                break;

            default:
                $this->showWelcome();
                $this->loadWords();
                $_SESSION["history"] = "";
                $_SESSION["num_of_guesses"] = 0;
        }
    }

    public function login() {
        if (isset($_POST['name'])) {
            $_SESSION["name"] = $_POST["name"];

            echo "hello";
        }

        if (isset($_POST['email'])) {
            $_SESSION["email"] = $_POST["email"];
            
        }

    }

    public function showWelcome() {
        include "welcomePage.php";
    }


    public function showGamePage() {
        include "gamePage.php";
    }

    public function logout() {

        session_destroy();
        session_start();
//        include "welcomePage.php";
    }


    public function showGameOverPage() {

        include "GameOverPage.php";

    }

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


            shuffle($printingWords);
            $shuffledWords = array();
            $shuffledWords = $printingWords;
            $_SESSION["shuffledWords"] = $shuffledWords;
        }

    }


    public function printWords() {
        if(empty($_SESSION["shuffledWords"])){
            return;
        }
        $printingWords = $_SESSION["shuffledWords"];
        $index = 1;
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

    public function checkAnswer() {

        echo "<br>";

        // TODO: warning when no user input
        if(array_key_exists("numbers", $_POST) == false){
            return;
        }

        if(empty($_POST["numbers"])){
            $_SESSION["history"] =  $_SESSION["history"] . "Null Input" . "<br>";
            echo $_SESSION["history"];
            return;
        }

        $numbers = array_unique(explode(" ", $_POST["numbers"]));

        $chosenWords = array();
        foreach ($numbers as $n) {
            array_push($chosenWords,  $_SESSION["shuffledWords"][$n]);
        }

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

//        print_r($ifSameCatDict);

        echo "<br>";

        // TODO: if user put in the same number multiple times
        if($ifSameCatDict){
            $maxSame = max($ifSameCatDict);
        }
        else{
            return;
        }
        $_SESSION["history"] =  $_SESSION["history"] . implode(", ", $chosenWords) . "<br>";
        if ($maxSame == 4) {
            $_SESSION["history"] =  $_SESSION["history"] . "You found one category!" . "<br>";
            foreach ($numbers as $n) {
                echo "here trying to unset";
                unset($_SESSION["shuffledWords"][$n]);
            }
        }
        if ($maxSame == 3) {
            $_SESSION["history"] =  $_SESSION["history"] . "You are 1 away!" . "<br>";
        }
        if ($maxSame == 2) {
            $_SESSION["history"] =  $_SESSION["history"] . "You are 2 away!" . "<br>";
        }
        if ($maxSame == 1) {
            $_SESSION["history"] =  $_SESSION["history"] . "Keep trying!" . "<br>";
        }

        echo $_SESSION["history"];
        $_SESSION["num_of_guesses"] = $_SESSION["num_of_guesses"] + 1;
    }

    public function printInfo(){
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
        $gusses = $_SESSION["num_of_guesses"];

        echo "Hi " . $name . " " . "your email is " . $email . "<br>";
        echo "You have made " . "$gusses" . " guesses" . "<br>";
    }

}

