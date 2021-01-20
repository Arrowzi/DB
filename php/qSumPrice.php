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
$select = "select  sum(b.price*ob.amount) as total from order_book ob join book b on b.id = ob.book_id join orders o on o.id = ob.order_id join client c on c.id = o.id_client where id_client=?;";
echo $select;
echo Utils::renderSelectQueryToTable($select,[$_POST["client_selector"]]);
?>
<a href="queries.php" class="back_button"> Назад</a>
<?
include "./html/bottom.html"
?>
