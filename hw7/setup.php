<?php


    $rows = $_GET["rows"];
    $cols = $_GET["columns"];

    $coordinates = [];
    if($rows * $cols < 7) {
        for($i = 0; $i < $rows; $i++) {
            for($j = 0; $j < $cols; $j++) {
                $coordinates[] = [$i, $j];
            }
        }
    }
    else{
        for ($i = 0; $i < 7; $i++) {
            $newPair = [rand(0, $rows - 1), rand(0, $cols - 1)];
            if(!in_array($newPair, $coordinates)) {
                $coordinates[] = $newPair;
            }
            else{
                $i = $i - 1;
            }
        }
    }

    echo json_encode($coordinates);