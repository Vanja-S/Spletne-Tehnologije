<?php

require_once ("BookDB.php");

?><!DOCTYPE html>

<meta charset="UTF-8" />
<title>Library</title>

<h1>A book library written in PHP</h1>

<p>Check our collection of fine books. <a href="search-books.php">Search for books.</a></p>

<ul>
    <?php foreach (BookDB::getAllBooks() as $book): 
        $id = key($book);
        $title = $book[$id]->getTitle();
        $author = $book[$id]->getAuthor();
    ?>
        <li><a href="book-detail.php?id=<?= $id ?>"><?= $author ?>: <?= $title ?></a></li>
    <?php endforeach; ?>
</ul>
