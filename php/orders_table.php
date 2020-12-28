<?
ob_start();
include "./html/top.html";
include "Utils.php";
$buffer = ob_get_contents();
ob_get_clean();

$title = "Список заказов";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
?>
    <h1>Таблица</h1>
    <h3>Список заказов</h3>
    <table>
        <tr>
            <th>№ заказа</th>
            <th>Дата создания заказа</th>
            <th>Состояние</th>
            <th>Заказчик</th>
        </tr>

        <?
        $db = Utils::getPDO();
        $state=['operating'=>'в обработке','canceled'=>'отменён','paid'=>'оплачен', 'done'=>'подтверждён'];
        foreach ($db->query("SELECT o.id as id, create_date, o_state, fname, sname FROM orders o join client c on c.id = o.id_client;") as $row) {
            echo "<tr>
            <th>{$row['id']}</th>
            <th>{$row['create_date']}</th>
            <th>{$state[$row['o_state']]}</th>
            <th>{$row['fname']} {$row['sname']}</th>
            </tr>";
        }
        ?>
    </table>

    <div class="operations">
        <!--    create    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="INSERT INTO orders(create_date,o_state,id_client) VALUES (:orders_create_date,:orders_state,:orders_client);">
            <input type="hidden" name="back" value="orders_table.php">
            <span>
                <b>Добавить заказ: </b>
            Заказчик
            <select name="orders_client" required>
                <?
                $db = Utils::getPDO();
                foreach ($db->query("SELECT id, fname, sname FROM client;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                }
                ?>
            </select>
            Дата создания заказа
                <input type="date" name="orders_create_date" required>
            Состояние заказа
                <select name="orders_state" required>
                    <option value="operating">в обработке</option>
                    <option value="canceled">отменён</option>
                    <option value="paid">оплачен</option>
                    <option value="done">подтверждён</option>
                </select>
            ?
                <input type="submit" value="Да">
        </span>
        </form>
        <!--    update    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE orders SET create_date=:new_create_date, o_state=:new_state WHERE id=:id_orders_selector;">
            <input type="hidden" name="back" value="orders_table.php">
            <span>
                <b>Изменить заказ №:</b>
                    <select name="id_orders_selector" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id FROM orders;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}</option>";
                    }
                    ?>
                    </select>
                Новая дата заказа:
                    <input type="date" name="new_create_date" required>
                состояние
                    <select name="new_state" required>
                    <option value="operating">в обработке</option>
                    <option value="canceled">отменён</option>
                    <option value="paid">оплачен</option>
                    <option value="done">подтверждён</option>
                    </select>
                ?
                    <input type="submit" value="Да">
            </span>
        </form>
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query"
                   value="UPDATE orders SET id_client=:new_client WHERE id=:id_orders_selector;">
            <input type="hidden" name="back" value="orders_table.php">
            <span>
                <b>Изменить заказчика у заказа №:</b>
                    <select name="id_orders_selector" required>
                    <?
                    $db = Utils::getPDO();
                    foreach ($db->query("SELECT id FROM orders;") as $row) {
                        echo "<option value='{$row['id']}'>{$row['id']}</option>";
                    }
                    ?>
                    </select>
                на
                    <select name="new_client" required>
                <?
                $db = Utils::getPDO();
                foreach ($db->query("SELECT id, fname, sname FROM client;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}: {$row['fname']} {$row['sname']}</option>";
                }
                ?>
            </select>
                    <input type="submit" value="Да">
            </span>
        </form>
        <!--    delete    -->
        <form action="handler.php" class="operation" method="post">
            <input type="hidden" name="query" value="DELETE FROM orders WHERE id=:id_orders_selector">
            <input type="hidden" name="back" value="orders_table.php">
            <span>
                <b>Удалить заказ №:</b>
            <select name="id_orders_selector" required>
                <?
                $db = Utils::getPDO();
                foreach ($db->query("SELECT id FROM orders;") as $row) {
                    echo "<option value='{$row['id']}'>{$row['id']}</option>";
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