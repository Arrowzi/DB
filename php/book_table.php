<?
ob_start();
include "./html/top.html";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Список книг";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Таблица</h1>
    <h3>Список книг</h3>
    <table>
        <tr>
            <th>id</th>
            <th>Название</th>
            <th>Дата публикации</th>
            <th>Возрастной рейтинг</th>
            <th>Статус</th>
            <th>Кол-во на складе</th>
            <th>Цена</th>
            <th>Автор</th>
        </tr>

        <?
        $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
        $state=['available'=>'в наличии','n_available'=>'нет в наличии','pre_order'=>'предзаказ'];
        foreach ($db->query("SELECT b.id as b_id ,title,public_date,raiting,b_state,amount,price,a.sname as sname,a.fname as fname FROM book b join author a on a.id = b.author_id;") as $row) {
            echo "<tr>
            <th>{$row['b_id']}</th>
            <th>{$row['title']}</th>
            <th>{$row['public_date']}</th>
            <th>{$row['raiting']}</th>
            <th>{$state[$row['b_state']]}</th>
            <th>{$row['amount']}</th>
            <th>{$row['price']}</th>
            <th>{$row['fname']} {$row['sname']}</th>
            </tr>";
        }
        ?>
    </table>

    <div class="operations">
        <!--    create    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="insert book(title,public_date,raiting,b_state,amount,price,author_id) values (:book_title,:book_public_date,:book_raiting,:book_state,:book_amount,:book_price,:book_author);">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Добавить книгу: </b><br>
            Название
                <input type="text" name="book_title" required>
            дата публикации
                <input type="date" name="book_public_date" required>
            рейтинг
                <select name="book_raiting" required>
                    <option value="0+">0+</option>
                    <option value="6+">6+</option>
                    <option value="12+">12+</option>
                    <option value="16+">16+</option>
                    <option value="18+">18+</option>
                </select>
            статус
                <select name="book_state" required>
                    <option value="available">в наличии</option>
                    <option value="n_available">нет в наличии</option>
                    <option value="pre_order">предзаказ</option>
                </select>
            кол-во
                <input type="number" min="0" max="10000" name="book_amount" required>
            цена
                <input type="number" min="0" max="10000" name="book_price" required>
            автор
                <select name="book_author" required>
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
        <!--    update    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE book SET title=:new_book_title WHERE id=:id_book_selector;">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Изменить название книги: </b>
                    <select name="id_book_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="text" name="new_book_title" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE book SET public_date=:new_public_date WHERE id=:id_book_selector;">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Изменить дату публикации книги: </b>
                    <select name="id_book_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="date" name="new_public_date" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE book SET raiting=:new_book_raiting WHERE id=:id_book_selector;">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Изменить возрастной рейтинг книги: </b>
                    <select name="id_book_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                на
                    <select name="new_book_raiting" required>
                        <option value="0+">0+</option>
                        <option value="6+">6+</option>
                        <option value="12+">12+</option>
                        <option value="16+">16+</option>
                        <option value="18+">18+</option>
                    </select>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE book SET b_state=:new_book_state WHERE id=:id_book_selector;">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Изменить статус книги: </b>
                    <select name="id_book_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                на
                    <select name="new_book_state" required>
                        <option value="available">в наличии</option>
                        <option value="n_available">нет в наличии</option>
                        <option value="pre_order">предзаказ</option>
                    </select>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE book SET amount=:new_book_amount WHERE id=:id_book_selector;">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Изменить колличество книги: </b>
                    <select name="id_book_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="number" min="0" max="10000" name="new_book_amount" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE book SET price=:new_book_price WHERE id=:id_book_selector;">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Изменить стоимость книги: </b>
                    <select name="id_book_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="number" min="0" max="10000" name="new_book_price" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE book SET author_id=:new_book_author WHERE id=:id_book_selector;">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Изменить автора книги: </b>
                    <select name="id_book_selector" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                на
                    <select name="new_book_author" required>
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

        <!--    delete    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="DELETE FROM book WHERE id=:id_book_selector">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Удалить книгу:</b>
            <select name="id_book_selector" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id, title FROM book;") as $row) {
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