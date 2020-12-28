<?
ob_start();
include "./html/top.html";
include "Utils.php";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Список клиентов";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Таблица</h1>
    <h3>Список клиентов</h3>
    <table>
        <tr>
            <th>id</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Номер телефона</th>
            <th>Адрес электронной почты</th>
            <th>Адрес проживания</th>
        </tr>

        <?
        $db = Utils::getPDO();
        foreach ($db->query("SELECT id, fname, sname, phone_number, email, c_address FROM client;") as $row) {
            echo "<tr>
            <th>{$row['id']}</th>
            <th>{$row['fname']}</th>
            <th>{$row['sname']}</th>
            <th>{$row['phone_number']}</th>
            <th>{$row['email']}</th>
            <th>{$row['c_address']}</th>
            </tr>";
        }
        ?>
    </table>

    <div class="operations">
        <!--    create    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="INSERT INTO client(fname, sname, phone_number, email, c_address) VALUES (:client_fname,:client_sname,:client_phone_number,:client_email,:client_address);">
            <input type="hidden" name="back" value="client_table.php">
            <span>
                <p><b>Добавить клиента: </b>
            Имя
                <input type="text" name="client_fname" required>
            фамилия
                <input type="text" name="client_sname" required>
            номер телефона
                <input type="tel" pattern="^(+7|7|8)?[\s-]?(?[489][0-9]{2})?[\s-]?[0-9]{3}[\s-]?[0-9]{2}[\s-]?[0-9]{2}$" name="client_phone_number" required>
            <p>адрес электронной почты
                <input type="email" name="client_email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$" size="30" required>
            адрес проживания
                <input type="text" name="client_address" required>
            ?
            <input type="submit" value="Да"></p>

        </span>
        </form>
        <!--    update    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE client SET fname=:new_client_fname, sname=:new_client_fname WHERE id=:id_client_selector;">
            <input type="hidden" name="back" value="client_table.php">
            <span>
                <b>Изменить имя и фамилию клиента:</b>
                    <select name="id_client_selector" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id, fname, sname FROM client;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="text" name="new_client_fname" required>
                    <input type="text" name="new_client_fname" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE client SET phone_number=:new_client_phone_number WHERE id=:id_client_selector;">
            <input type="hidden" name="back" value="client_table.php">
            <span>
                <b>Изменить номер телефона клиента:</b>
                    <select name="id_client_selector" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id, fname, sname FROM client;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="tel" pattern="^(+7|7|8)?[\s-]?(?[489][0-9]{2})?[\s-]?[0-9]{3}[\s-]?[0-9]{2}[\s-]?[0-9]{2}$" name="new_client_phone_number" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE client SET email=:new_client_email WHERE id=:id_client_selector;">
            <input type="hidden" name="back" value="client_table.php">
            <span>
                <b>Изменить адрес электронной почты клиента:</b>
                    <select name="id_client_selector" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id, fname, sname FROM client;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="email" name="client_email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$" size="30" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE client SET c_adress=:new_client_adress WHERE id=:id_client_selector;">
            <input type="hidden" name="back" value="client_table.php">
            <span>
                <b>Изменить адрес проживания клиента:</b>
                    <select name="id_client_selector" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id, fname, sname FROM client;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                    }
                    ?>
                    </select>
                на
                    <input type="text" name="new_client_adress" required>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>

        <!--    delete    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="DELETE FROM client WHERE id=:id_client_selector">
            <input type="hidden" name="back" value="client_table.php">
            <span>
                <p><b>Удалить клиента:</b>
            <select name="id_client_selector" required>
                <?
                $db = Utils::getPDO();
                foreach ($db->query("SELECT id, fname, sname FROM client;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                }
                ?>
            </select>
             ?
                    <input type="submit" value="Да"></p>
            </span>
        </form>
    </div>
    <a href="tables_index.php" class="back_button"> Назад</a>
<?
include "./html/bottom.html";
?>