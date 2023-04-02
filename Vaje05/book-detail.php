<?php

require_once ("BookDB.php");

?><!DOCTYPE html>
<meta charset="UTF-8" />
<title>Book detail</title>

<?php $book = BookDB::get($_GET["id"]); ?>

<h1>Details about: <?= $book ?></h1>

<ul>
    <li><strong>Author:</strong> <?= $book->author ?></li>
    <li><strong>Title:</strong> <?= $book->title ?></li>
    <li><strong>Price:</strong> <?= $book->price ?></li>
</ul>