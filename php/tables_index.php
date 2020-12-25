<?
ob_start();
include "./html/top.html";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Выбор таблицы";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Таблицы</h1>
    <h2>Выберите таблицу для работы</h2>
    <a href="author_table.php" class="table__selector">авторы</a>
    <a href="book_table.php" class="table__selector">книги</a>
    <a href="genre_table.php" class="table__selector">жанры</a>
    <a href="client_table.php" class="table__selector">покупатели</a>
    <a href="orders_table.php" class="table__selector">заказы</a>
    <a href="book_genre_table.php" class="table__selector">жанры книг</a>
    <a href="order_book_table.php" class="table__selector">заказ покупателя</a>
<?
include "./html/bottom.html"
?>