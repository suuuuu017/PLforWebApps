<?php
/**
 * Homework 4 - PHP Introduction
 *
 * Computing ID: qvw9pv
 * Resources used: https://www.php.net/manual/en/
 */

// Your functions here

// No closing php tag needed since there is only PHP in this file


function calculateGrade($scores, $drop) {
    $minS = PHP_INT_MAX;
    $minSc = 0;
    $minMax = 0;
    $sum = 0;
    $sumMax = 0;
    foreach($scores as $s) {
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
    if($sumMax == 0) {
        return 0;
    }
    $average = $sum / $sumMax * 100;
    $average = round($average, 3);
    return $average;
}

function gridCorners($width, $height) {
    if($width < 1 || $height < 1) {
        return "";
    }
    if($width < 2) {
        $s = "";
        for($i = 1; $i <= $height - 1; $i++) {
            $s = $s . $i . ", ";
        }
        $s = $s . $i;
        return $s;
    }
    if($height < 2) {
        $s = "";
        for($i = 1; $i <= $width - 1; $i++) {
            $s = $s . $i . ", ";
        }
        $s = $s . $i;
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
    for($i = 0; $i < count($result) - 1; $i++) {
        $s = $s . $result[$i] . ", ";
    }
    $s = $s . $result[count($result) - 1];
    return $s;
}

function combineShoppingLists(...$lists){
//    if(func_num_args() == 0){
//        return [];
//    }
//    if(func_num_args() == 1) {
//        $oneList = $list1;
//        if($list1 == null) {
//            $oneList = $list2;
//        }
//        $result = [];
//        if(array_key_exists("list", $oneList) == false) {
//            return $result;
//        }
//        sort($oneList["list"]);
//        $l1 = $oneList["list"];
//        for($i= 0; $i < count($l1); $i++) {
//            $result[$oneList["list"][$i]] = [$oneList["user"]];
//        }
//        return $result;
//    }
//    $result = [];
//    $l1 = 0;
//    $l2 = 0;
//    if(array_key_exists("list", $list1) == false) {
//        $list1["list"] = [];
//    }
//    else{
//        sort($list1["list"]);
//        $l1 = count($list1["list"]);
//    }
//    if(array_key_exists("list", $list2) == false) {
//        $list2["list"] = [];
//    }
//    else{
//        sort($list2["list"]);
//        $l2 = count($list2["list"]);
//    }
//
//    $i= 0;
//    $j= 0;
//    while($i < $l1 || $j < $l2){
//        if ($i < $l1 && $j < $l2 && $list1["list"][$i] == $list2["list"][$j]) {
//            $result[$list1["list"][$i]] = [$list1["user"], $list2["user"]];
////            echo $list1["user"]. $list2["user"];
//            $i = $i + 1;
//            $j = $j + 1;
//        }
//        else{
//            if($i < $l1){
//                $result[$list1["list"][$i]] = [$list1["user"]];
////                echo $list1["user"];
//                $i = $i + 1;
//            }
//            else{
//                $result[$list2["list"][$j]] = [$list2["user"]];
////                echo $list2["user"];
//                $j = $j + 1;
//            }
//        }
//    }
//    ksort($result);
//    $resultList = "[\n";
//    foreach($result as $key => $value) {
//        $resultList = $resultList."\"$key\" => \"";
//        foreach($value as $item) {
//            $resultList = $resultList."$item\", ";
//        }
//        $resultList = $resultList."],<br>[";
//    }
    $result = [];
    foreach($lists as $l) {
        if($l != null){
            foreach($l["list"] as $food){
                if(key_exists($food, $result)) {
                    if($l["user"] != null && in_array($l["user"], $result[$food]) == false){
                        array_push($result[$food], $l["user"]);
                    }
                }
                else {
                    $result[$food] = [$l["user"]];
                }
            }
        }

    }
    ksort($result);
    return $result;
}

function validateEmail($email){
    $pattern = '/^[A-Za-z0-9\-_+]+(\.[A-Za-z0-9\-_+]+)*[A-Za-z0-9\-_+]+@[A-Za-z0-9\-]+(\.[A-Za-z0-9\-]+)*$/';
    if(func_num_args() >= 2) {
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