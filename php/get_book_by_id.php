<?
if (!empty($_GET)) {
    include 'Utils.php';
    $db = Utils::getPDO();
    $id = $_GET['id'];
    $statement = $db->prepare('select * from book where id=?;');
    $statement->execute([$id]);
    echo json_encode($statement->fetchAll()[0]);
}