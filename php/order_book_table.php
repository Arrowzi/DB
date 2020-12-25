<?
ob_start();
include "./html/top.html";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Таблица книг в заказе";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Таблица</h1>
    <h3>Таблица книг в заказе</h3>
    <table>
        <tr>
            <th>Номер заказа</th>
            <th>id книги</th>
            <th>Название книги</th>
        </tr>
        <?
        $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
        foreach ($db->query("SELECT o.id as order_id, group_concat(b.id) as book_id, group_concat(b.title) as book_title from  order_book join book b on b.id = order_book.book_id join orders o on o.id = order_book.order_id group by o.id") as $row) {
            echo "<tr>
            <th>№ {$row['order_id']}</th>
            <th>{$row['book_id']}</th>
            <th>{$row['book_title']}</th>
            </tr>";
        }
        ?>
    </table>
    <div class="operations">
        <!--    create    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="INSERT INTO order_book(book_id, order_id) VALUES (:book_id, :order_id);">
            <input type="hidden" name="back" value="order_book_table.php">
            <span>
            Добавить книгу
                <select name="book_id" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['title']}</option>";
                    }
                    ?>
                </select>
                в заказ №:
                <select name="order_id" required>
                    <?
                    $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                    foreach ($db->query("SELECT id FROM orders;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}</option>";
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
                   value="DELETE FROM order_book WHERE book_id=:id_book_selector and order_id=:id_order_selector;">
            <input type="hidden" name="back" value="order_book_table.php">
            <span>
            Удалить из заказа №:
            <select name="id_order_selector" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id FROM orders;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}</option>";
                }
                ?>
            </select>
                книгу
                <select name="id_book_selector" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id, title FROM book;") as $row) {
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