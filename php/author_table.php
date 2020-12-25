<?
ob_start();
include "./html/top.html";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Список авторов";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Таблица</h1>
    <h3>Список авторов</h3>
    <table>
        <tr>
            <th>id</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Дата рождения</th>
        </tr>

        <?
        $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
        foreach ($db->query("SELECT id, fname, sname, dob FROM author;") as $row) {
            echo "<tr>
            <th>{$row['id']}</th>
            <th>{$row['fname']}</th>
            <th>{$row['sname']}</th>
            <th>{$row['dob']}</th>
            </tr>";
        }
        ?>
    </table>

    <div class="operations">
        <!--    create    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="INSERT INTO author(fname, sname, dob) VALUES (:author_fname, :author_sname, :author_dob);">
            <input type="hidden" name="back" value="author_table.php">
            <span>
                <b>Добавить автора: </b><br>
            Имя
                <input type="text" name="author_fname" required>
            фамилия
                <input type="text" name="author_sname" required>
            дата рождения
                <input type="date" name="author_dob" required>
            ?
                <input type="submit" value="Да">
        </span>
        </form>
        <!--    update    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE author SET fname=:new_author_fname, sname=:new_author_sname WHERE id=:id_author_selector;">
            <input type="hidden" name="back" value="author_table.php">
            <span>
                <b>Изменить имя и фaмилию автора:</b>
                    <select name="id_author_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                     foreach ($db->query("SELECT id, fname, sname FROM author;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                     }
                     ?>
                    </select><br>
                Имя
                    <input type="text" name="new_author_fname" required>
                фамилия
                    <input type="text" name="new_author_sname" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>

        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE author SET dob=:new_author_dob WHERE id=:id_author_selector;">
            <input type="hidden" name="back" value="author_table.php">
            <span>
                <b>Изменить дату рождения автора:</b>
                <select name="id_author_selector" required>
                  <?
                  $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                  foreach ($db->query("SELECT id, fname, sname FROM author;") as $row) {
                      echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                  }
                  ?>
                </select><br>
            Дата рождения
                <input type="date" name="new_author_dob">
            ?
                <input type="submit" value="Да">
            </span>
        </form>
        <!--    delete    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="DELETE FROM author WHERE id=:id_author_selector">
            <input type="hidden" name="back" value="author_table.php">
            <span>
                <b>Удалить автора:</b>
            <select name="id_author_selector" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id, fname, sname FROM author;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                }
                ?>
            </select>
             ?
            <input type="submit" value="Да">
            </span>
        </form>
    </div>
    <a href="tables_index.php" class="back_button"> Назад</a>
<?
include "./html/bottom.html";
?>