<?php


use JetBrains\PhpStorm\Pure;

class Utils
{
    public static function renderSelectQueryToTable(string $query, array $data): string
    {
        $db = Utils::getPDO();
        $stmt = $db->prepare($query);
        $stmt->execute($data);
        $result = $stmt->fetchAll();
        return $result ? Utils::renderTable($result) : "Запрос вернул пустой результат";
    }

    public static function getPDO(): PDO
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO('mysql:host=db;dbname=bookmarket', 'devuser', 'devpass', $options);
    }

    public static function renderTable(array $array): string
    {
        $html = '<table>';

        $html .= '<tr>';
        foreach ($array[0] as $key => $value) {
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
        $html .= '</tr>';

        foreach ($array as $key => $value) {
            $html .= '<tr>';
            foreach ($value as $key2 => $value2) {
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table>';
        return $html;
    }
}