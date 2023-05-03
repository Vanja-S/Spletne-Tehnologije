<!DOCTYPE html>

<meta charset="UTF-8" />
<title>Edit entry</title>
<style type="text/css">
    .important {
        color: red;
    } 
</style>

<h1>Edit the book</h1>
<h2><?= $author?>: <?= $title?></h2>
<br>
<form action="<?= BASE_URL . "book/edit" ?>" method="post">
    <input type="hidden" name="id" value="<?= $id ?>"/>
    <p><label>Author: <input type="text" name="author" value="<?= $author ?>" autofocus /></label></p>
    <p><label>Title: <input type="text" name="title" value="<?= $title ?>" /></label></p>
    <p><label>Price: <input type="number" name="price" value="<?= $price ?>" /></label></p>
    <p><label>Year: <input type="number" name="year" value="<?= $year ?>" /></label></p>
    <p><button>Change</button></p>
</form>
