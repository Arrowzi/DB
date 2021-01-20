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
$select = "select a.fname, a.sname, count(*) as amount from author a join book b on a.id = b.author_id group by a.fname, a.sname order by amount desc limit ?;";
echo $select;
echo Utils::renderSelectQueryToTable($select,[$_POST["top"]])
?>
    <a href="queries.php" class="back_button"> Назад</a>
<?
include "./html/bottom.html"
?>