<!DOCTYPE html>

<meta charset="UTF-8" />
<title>Prime number check</title>

<h1>Prime number check</h1>

<p><?php

date_default_timezone_set("Europe/Ljubljana");

echo "Welcome to the PHP page. Today's date is " . date("d.m.Y") . " and the hour is " . date("H:i") . ".";

?></p>

<p>Check if a number is prime by submitting the following form.</p>

<form action="check-prime.php" method="get">
    <label for="number">Number:</label>
    <input type="number" name="number" id="number" />
    <button type="submit">Check if prime.</button>
</form>
