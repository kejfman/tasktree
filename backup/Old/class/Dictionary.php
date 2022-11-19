<?php

class Dictionary
{
    private $content; //zawartość
    private $id; //identyfikator słownika

    /**
     * konstruktow tworzący obiekt Dictionary
     * @var mysqli $db_connect - połączenie z bazą danych
     * @var array $id -  identyfikator wybranego słownika
     */
    public function __construct(mysqli $db_connect, string $id)
    {
        $this->id = $id;
        $select_query = "SELECT value FROM pt_dictionary WHERE destination = '$id'";
        if ($seletc_result = $db_connect->query($select_query)) {
            $i = 0;
            while ($select_row = $seletc_result->fetch_assoc()) {
                $this->content[$i] = $select_row['value'];
                $i++;
            }
        } else {
            echo "Błąd podczas komunikacji z bazą danych, skontaktuj się z administratorem! - Dictionary::__construct";
        }
    }

    /**
     * funkcja umożliwia pobranie zawartości wybranego słownika
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * funkcja umożliwia dodanie rekordu do wybranego słownika
     * @var mysqli $db_connect - połączenie z bazą danych
     * @var string $dict_id - identyfikator wybranego słownika
     * @var string $dict_value - vartość rekordu który zostanie dodany do słownika
     */
    public static function addToDictionary(mysqli $db_connect, string $dict_id, string $dict_value)
    {
        $dict_value = trim($dict_value);
        $dict_value = strip_tags($dict_value);
        $dict_value = htmlspecialchars($dict_value);

        $insert_query = "INSERT INTO pt_dictionary (destination, value) VALUES ('$dict_id', '$dict_value')";
        if ($db_connect->query($insert_query)) {
            return true;
        } else {
            echo "Błąd podczas komunikacji z bazą danych, skontaktuj się z administratorem! - Dictionary::addToDictionary";
        }
    }

    /**
     * funkcja umożliwia usunięcie wybranego rekordu ze słownika
     * @var mysqli $db_connect - połączenie z bazą danych
     * @var string $dict_content - wyrażenie jednoznacznie identyfikujące wybrany rekord {"id_value"}
     */
    public static function deleteValueDictionary(mysqli $db_connect, string $dict_content)
    {
        $delete_query = "DELETE FROM pt_dictionary WHERE id in ($dict_content)";
        if ($db_connect->query($delete_query)) {

            return true;
        } else {
            echo "Błąd podczas komunikacji z bazą danych, skontaktuj się z administratorem! - Dictionary::deleteValueDictionary";
        }
    }

    public static function getSelectedDictionaryValues(mysqli $db_connect, string $dict_name)
    {
        $select_query = "SELECT id, value FROM pt_dictionary WHERE destination = '$dict_name';";
        if ($select_result = $db_connect->query($select_query)) {
            $i = 0;
            while ($select_row = $select_result->fetch_assoc()) {
                $dictContent[$i]['id'] = $select_row['id'];
                $dictContent[$i]['value'] = $select_row['value'];
                $i++;
            }
            if (isset($dictContent) && is_array($dictContent) && !empty($dictContent)) {
                return $dictContent;
            }
        } else {
            echo "Błąd podczas komunikacji z bazą danych, skontaktuj się z administratorem! - Dictionary::getSelectedDictionaryValues";
        }
    }
}
