<?php
/**
 * Homework 4 - PHP Introduction
 *
 * Computing ID:
 * Resources used: [list any resources used to complete this assignment]
 */

// Your functions here

// No closing php tag needed since there is only PHP in this file

function calculateGrade($scores, $drop) {
    $minS = 100;
    $minSc = 0;
    $minMax = 0;
    $sum = 0;
    $sumMax = 0;
    foreach ($scores as $s ) {
        if ($s["score"] / $s["max_points"] < $minS) {
            $minS = $s["score"] / $s["max_points"];
            $minSc = $s["score"];
            $minMax = $s["max_points"];
        }
        $sum += $s["score"];
        $sumMax += $s["max_points"];
    }
    if ($drop) {
        $sum -= $minSc;
        $sumMax -= $minMax;
    }
    $average = $sum / $sumMax * 100;
    return $average;
}

function gridCorners($width, $height) {
    if($width < 2) {
        $s = "";
        for($i = 1; $i <= $height; $i++) {
            $s = $s . $i . ", ";
        }
        return $s;
    }
    if($height < 2) {
        $s = "";
        for($i = 1; $i <= $width; $i++) {
            $s = $s . $i . ", ";
        }
        return $s;
    }
    $result = [];
    array_push($result, $height);
    array_push($result, $height - 1);
    array_push($result, $height + $height);
    array_push($result, 1);
    array_push($result, 1 + 1);
    array_push($result, 1 + $height);
    array_push($result, $width * $height);
    array_push($result, $width * $height - 1);
    array_push($result, $width * $height - $height);
    array_push($result, ($width - 1) * $height + 1);
    array_push($result, ($width - 1) * $height + 1 + 1);
    array_push($result, ($width - 1) * $height + 1 - $height);
    $result = array_unique($result);
    sort($result);
    $s = "";
    for($i = 0; $i < count($result); $i++) {
        $s = $s . $result[$i] . ", ";
    }
    return $s;
}

function combineShoppingLists($list1, $list2){
    $result = [];
    sort($list1["list"]);
    sort($list2["list"]);
    $l1 = $list1["list"];
    $l2 = $list2["list"];
    for($i= 0; $i < count($l1); $i++) {
        for($j = 0; $j < count($l2); $j++) {
            if ($list1["list"][$i] === $list2["list"][$j]) {
                $result[$list1["list"][$i]] = [$list1["user"], $list2["user"]];
            }
            else{
                if( $i < count($l1)){
                    $result[$list1["list"][$i]] = [$list1["user"]];
                }
                $result[$list2["list"][$j]] = [$list2["user"]];
            }
            $i = $i + 1;
        }
        $result[$list1["list"][$i]] = [$list1["user"]];
    }

    return $result;
}

function validateEmail($email){
    $pattern = '/^[A-Za-z0-9-_+]+(\.[A-Za-z0-9-_+]+)*[A-Za-z0-9-_+]+@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*$/';
    if (func_num_args() >= 2) {
        $customPattern = func_get_arg(1);
    }
    else {
        $customPattern = null;
    }
    if(preg_match($pattern, $email)) {
        if($customPattern != null) {
            if(preg_match($customPattern, $email)) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return true;
        }
    }
    else {
        return false;
    }

}