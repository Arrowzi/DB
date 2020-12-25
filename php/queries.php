<?
ob_start();
include "./html/top.html";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Запросы";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Запросы</h1>
    <div class="operations">
        <form method="post" action="qAuthorBook.php">
            1) Список всех книг по автору:
            <select name="id_author_selector" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id, fname, sname FROM author;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                }
                ?>
            </select>
            <button type="submit" name="book_author" class="back_button">Ок</button>
        </form>
    </div>
    <div class="operations">
        <form method="POST" action="qBookRating.php">
            2) Вывод всех книг по возрастному рейтингу:
                <select name="rating" required>
                    <option value="0+">0+</option>
                    <option value="6+">6+</option>
                    <option value="12+">12+</option>
                    <option value="16+">16+</option>
                    <option value="18+">18+</option>
            </select>
            <button type="submit" name="book_rating" class="back_button">Ок</button>
        </form>
    </div>
    <div class="operations">
        <form method="POST" action="qBookPrice.php">
            3) Вывод всех книг в указанном ценовом диапазоне: от
                    <input type="number" min="0" max="10000" name="min" required>
                до
                    <input type="number" min="0" max="10000" name="max" required>
                <button type="submit" name="title_rating" class="back_button">Ок</button>
        </form>
    </div>
    <div class="operations">
        <form method="post" action="qBookGenre.php">
            4) Вывод всех книг опеределённого жанра:
            <select name="all_genre" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id, title FROM genre;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                }
                ?>
            </select>
            <button type="submit" name="select_genre" class="back_button">Ок</button>
        </form>
    </div>
    <div class="operations">
        <form method="post" action="qBookYear.php">
            5) Вывод всех книг вышедших в определённом году:
            <input type="number" min="1950" max="2020" step="1" required>
            <button type="submit" name="book_year" class="back_button">Ок</button>
        </form>
    </div>
    <div class="operations">
        <form method="post" action="qOrderGenre.php">
            6) Вывод всех заказов по жанру книги:
            <select name="all_genre" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id, title FROM genre;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['title']}</option>";
                }
                ?>
            </select>
            <button type="submit" name="select_genre" class="back_button">Ок</button>
        </form>
    </div>
    <div class="operations">
        <form action="qSumPrice.php">
            7) Вывод суммы всех покупок пользовтеля:
            <select name="client_selector" required>
                <?
                $db = new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass');
                foreach ($db->query("SELECT id, fname, sname FROM client;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                }
                ?>
            </select>
            <button type="submit" name="sum_price" class="back_button">Ок</button>
        </form>
    </div>

<?
include "./html/bottom.html"
?>