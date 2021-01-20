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
$select = "select c.fname,c.sname, sum(ob.amount) as amount from client c join orders o on c.id = o.id_client join order_book ob on o.id = ob.order_id where year(create_date)=2020 and month(create_date)=? group by c.fname, c.sname order by amount desc limit ? ;";
echo $select;
echo Utils::renderSelectQueryToTable($select,[$_POST["month_selector"],$_POST["top"]])
?>
    <a href="queries.php" class="back_button"> Назад</a>
<?
include "./html/bottom.html"
?>