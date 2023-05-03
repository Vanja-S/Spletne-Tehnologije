<!DOCTYPE html>

<meta charset="UTF-8" />
<title>Search for a book</title>
<style type="text/css">
    .important {
        color: red;
    } 
</style>

<h1>Search for a book</h1>

<form action="<?= BASE_URL . "book/search" ?>" method="post">
    <p><label>Search: <input type="text" name="name" value="<?= $name ?>" autofocus /></label></p>
    <p><button>Search</button></p>
</form>


<ul>

    <?php foreach ($books as $book): ?>
        <li><a href="<?= BASE_URL . "book?id=" . $book["id"] ?>"><?= $book["author"] ?>: 
        	<?= $book["title"] ?> (<?= $book["year"] ?>)</a></li>
    <?php endforeach; ?>

</ul>