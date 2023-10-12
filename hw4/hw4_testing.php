<?php
include("homework4.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="your name">
    <meta name="description" content="include some description about your page">

    <title>Homework 4 Test File</title>
</head>
<body>
<h1>Homework 4 Test File</h1>

<h2>Problem 1</h2>
<?php
echo "Write tests for Problem 1 here\n";
$test1 = [ [ "score" => 30, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ], [ "score" => 80, "max_points" => 100 ] ];
echo calculateGrade($test1, false); // should be 55
echo "\n";

echo gridCorners(3, 1);
echo "\n";

$list1 = ["user" => "Fred", "list" => ["frozen pizza", "bread", "apples", "oranges"]];

$list2 = ["user" => "Wilma", "list" => ["bread", "apples", "coffee"]];
print_r(count($list1["list"]));
echo"\n";
echo print_r(combineShoppingLists($list1, $list2));

echo validateEmail("orange@virginia.edu"); // returns true
echo "\n";
echo validateEmail("no-reply@google.com"); // returns true
echo "\n";
echo validateEmail("orange.and.+blue@virginia.edu"); // returns true
echo "\n";
echo validateEmail("google.com"); // returns false
echo "\n";
echo validateEmail("mst3k@virginia.edu", "/^[a-z][a-z][a-z]?[0-9][a-z][a-z]?[a-z]?@virginia.edu$/"); // returns true
echo "\n";
echo validateEmail("orange@virginia.edu", "/^[a-z][a-z][a-z]?[0-9][a-z][a-z]?[a-z]?@virginia.edu$/"); // returns false
echo "\n";
echo validateEmail("orange@blue.com", "/^[a-z\.@]+$/"); // returns true
echo "\n";
echo validateEmail("orangeblue.com", "/^[a-z\.@]+$/"); // returns false (but matches this regex)
echo "\n";
echo validateEmail("orange123@blue.com", "/^[a-z\.@]+$/"); // returns false
?>


<p>...</p>
</body>
</html>
