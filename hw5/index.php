<?php

spl_autoload_register(function ($classname) {
include "CategoryGameController.php";

});

$_SESSION["connections"] = new CategoryGameController($_GET);

$_SESSION["connections"]->run();