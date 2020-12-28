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
echo Utils::renderSelectQueryToTable("select b.id as id, b.title as title, public_date, raiting, b_state, amount, price, fname, sname, group_concat(g.title) as genre_title from book b join author a on a.id = b.author_id join book_genre bg on b.id = bg.book_id join genre g on g.id = bg.genre_id where b.raiting=? group by b.id, b.title, public_date, raiting, b_state, amount, price, fname, sname;",[$_POST["rating"]])
?>
    <a href="queries.php" class="back_button"> Назад</a>
<?
include "./html/bottom.html"
?>