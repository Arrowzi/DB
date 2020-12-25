<?
ob_start();
include "./html/top.html";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Список жанров";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Таблица</h1>
    <h3>Список жанров</h3>
    <table>
        <tr>
            <th>id</th>
            <th>Название жанра</th>
        </tr>

        <?
        $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
        foreach ($db->query("SELECT id, title FROM genre;") as $row) {
            echo "<tr>
            <th>{$row['id']}</th>
            <th>{$row['title']}</th>
            </tr>";
        }
        ?>
    </table>

    <div class="operations">
        <!--    create    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="INSERT INTO genre(title) VALUES (:genre_title);">
            <input type="hidden" name="back" value="genre_table.php">
            <span>
                <b>Добавить жанр: </b>
            название
                <input type="text" name="genre_title" required>
            ?
                <input type="submit" value="Да">
        </span>
        </form>
        <!--    update    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE genre SET title=:new_genre_title WHERE id=:id_genre_selector;">
            <input type="hidden" name="back" value="genre_table.php">
            <span>
                <b>Изменить название жанра:</b>
                    <select name="id_genre_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM genre;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="text" name="new_genre_title" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <!--    delete    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="DELETE FROM genre WHERE id=:id_genre_selector">
            <input type="hidden" name="back" value="genre_table.php">
            <span>
                <b>Удалить жанр:</b>
            <select name="id_genre_selector" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id, title FROM genre;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
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