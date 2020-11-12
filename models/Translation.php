<?php
class Translation
{
    private $db;
    private $table = "translations";

    public $id;
    public $spelling;
    public $pronunciation;
    public $needsRepeating;
    public $languageId;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllTranslationsByLanguage($lang)
    {
        $query = "SELECT t.id, t.pronunciation, t.spelling, t.needsRepeating, t.languageId, l.code  FROM " . $this->table . " t LEFT JOIN languages l ON t.languageId = l.id WHERE t.languageId = " . $lang;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
