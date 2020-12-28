<?
ob_start();
include "./html/top.html";
include 'Utils.php';
$buffer = ob_get_contents();
ob_get_clean();

$title = "Таблица книжных жанров";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Таблица</h1>
    <h3>Таблица книжных жанров</h3>
    <table>
        <tr>
            <th>id книги</th>
            <th>Название книги</th>
            <th>id жанра</th>
            <th>Название жанра</th>
        </tr>
        <?
        $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
        foreach ($db->query("select b.id as book_id,b.title as book_title,group_concat(g.id) as genre_id, group_concat(g.title)as genre_title from book_genre join book b on b.id = book_genre.book_id join genre g on g.id = book_genre.genre_id group by b.id, b.title order by b.id;") as $row) {
            echo "<tr>
            <th>{$row['book_id']}</th>
            <th>{$row['book_title']}</th>
            <th>{$row['genre_id']}</th>
            <th>{$row['genre_title']}</th>
            </tr>";
        }
        ?>
    </table>
    <div class="operations">
        <!--    create    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="INSERT INTO book_genre(book_id, genre_id) VALUES (:book_id, :genre_id);">
            <input type="hidden" name="back" value="book_genre_table.php">
            <span>
            Добавить жанр
                <select name="genre_id" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id, title FROM genre;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['title']}</option>";
                    }
                    ?>
                </select>
                книге
                <select name="book_id" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id, title FROM book order by id;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                </select>
            ?
            <input type="submit" id="create" value="Да">
        </span>
        </form>
        <!--    delete    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="DELETE FROM book_genre WHERE book_id=:id_book_selector and genre_id=:id_genre_selector;">
            <input type="hidden" name="back" value="book_genre_table.php">
            <span>
            У книги
            <select name="id_book_selector" required>
                <?
                $db = Utils::getPDO();
                foreach ($db->query("SELECT id, title FROM book order by id;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                }
                ?>
            </select>
                удалить жанр
                <select name="id_genre_selector" required>
                <?
                $db = Utils::getPDO();
                foreach ($db->query("SELECT id, title FROM genre;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['title']}</option>";
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