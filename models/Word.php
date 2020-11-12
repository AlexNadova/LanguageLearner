<?php
class Word
{
    private $db;
    private $table = "words";

    public $id;
    public $spelling;
    public $languageId;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllWords()
    {
        $query = "SELECT * FROM " . $this->table . " w LEFT JOIN languages l ON w.languageId = l.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getWordById($id)
    {
        $query = "SELECT * FROM " . $this->table . " w LEFT JOIN languages l ON w.languageId = l.id WHERE w.id = " . $id;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
