<!DOCTYPE html>
<meta charset="utf-8">
<title>Processing GET parameters</title>

<?php

if (isset($_GET["last_name"]) and isset($_GET["first_name"]) and !empty($_GET["last_name"]) and !empty($_GET["first_name"])) {
    echo "Hello {$_GET['first_name']} {$_GET['last_name']} the time is " . date('H:i') . ".";
} else {
    echo "Required parameters are missing.";
}
?>