<?
ob_start();
include "./html/top.html";
include "Utils.php";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Запросы";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
<?
$select = "select o.id as order_number, create_date, o_state, fname,sname,b.title as title, public_date, raiting, b_state, price, g.title as name_genre from orders o join client c on c.id = o.id_client join order_book ob on o.id = ob.order_id join book b on b.id = ob.book_id join book_genre bg on b.id = bg.book_id join genre g on g.id = bg.genre_id where g.id = ?;";
echo $select;
echo Utils::renderSelectQueryToTable($select,[$_POST["all_genre"]])
?>
<a href="queries.php" class="back_button"> Назад</a>
<?
include "./html/bottom.html"
?>
