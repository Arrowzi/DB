<?
ob_start();
include "./html/top.html";
include "Utils.php";
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
        $db = Utils::getPDO();
        $state = ['available' => 'в наличии', 'n_available' => 'нет в наличии', 'pre_order' => 'предзаказ'];
        foreach ($db->query("SELECT b.id as b_id ,title,public_date,raiting,b_state,amount,price,a.sname as sname,a.fname as fname FROM book b join author a on a.id = b.author_id order by b.id;") as $row) {
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
    <script>
        function on_change() {
            const current_host = window.location.host;
            const id = document.getElementById("id_book_selector").value;
            const request = async () => {
                const response = await fetch(`${location.protocol}//${current_host}/get_book_by_id.php?id=${id}`);
                const json = await response.json();
                document.getElementById("new_book_title").value = json["title"];
                document.getElementById("new_public_date").value = json["public_date"];
                document.getElementById("new_book_raiting").value = json["raiting"];
                document.getElementById("new_book_state").value = json["b_state"];
                document.getElementById("new_book_amount").value = json["amount"];
                document.getElementById("new_book_price").value = json["price"];
                document.getElementById("new_book_author").value = json["author_id"];
            }
            request();
        }

    </script>
    <div class="operations">
        <!--    create    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="insert book(title,public_date,raiting,b_state,amount,price,author_id) values (:book_title,:book_public_date,:book_raiting,:book_state,:book_amount,:book_price,:book_author);">
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
                <select id="book_author" name="book_author" required>
                    <?
                    $db = Utils::getPDO();
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
                   value="UPDATE book SET author_id=:new_book_author, price=:new_book_price, amount=:new_book_amount, b_state=:new_book_state,title=:new_book_title, public_date=:new_public_date, raiting=:new_book_raiting WHERE id=:id_book_selector;">
            <input type="hidden" name="back" value="book_table.php">
            <span>
                <b>Обновить информацию книги: </b>
                    <select id="id_book_selector" name="id_book_selector" onchange="on_change()" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id, title FROM book;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                    }
                    ?>
                    </select>
                <br>
                Название
                    <input id="new_book_title" type="text" name="new_book_title" required>
                дата публикации
                    <input id="new_public_date" type="date" name="new_public_date" required>
                рейтинг
                    <select id="new_book_raiting" name="new_book_raiting" required>
                        <option value="0+">0+</option>
                        <option value="6+">6+</option>
                        <option value="12+">12+</option>
                        <option value="16+">16+</option>
                        <option value="18+">18+</option>
                    </select>
                статус
                    <select id="new_book_state" name="new_book_state" required>
                        <option value="available">в наличии</option>
                        <option value="n_available">нет в наличии</option>
                        <option value="pre_order">предзаказ</option>
                    </select>
                кол-во
                    <input id="new_book_amount" type="number" min="0" max="10000" name="new_book_amount" required>
                цена
                    <input id="new_book_price" type="number" min="0" max="10000" name="new_book_price" required>
                автор
                    <select id="new_book_author" name="new_book_author" required>
                    <?
                    $db = Utils::getPDO();
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
                $db = Utils::getPDO();
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