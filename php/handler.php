<?
ob_start();
include "./html/top.html";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Таблица";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
<h1>Таблицы</h1>
<?
if (!empty($_POST)) {

    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
    $query = $db->prepare($_POST['query']);
    $back = $_POST['back'];
    unset($_POST['back']);
    unset($_POST['query']);
    $result = $query->execute($_POST);

    if ($result) {
        echo "<h1>Успешно</h1>";
    } else {
        echo "<h1>Ошибка</h1>";
    }
    echo "<a class='back_button' href='{$back}'>Назад</a>";
} else {
    echo "<h1>Ошибка</h1>";
}
?>
<?
include "./html/bottom.html";
?>
