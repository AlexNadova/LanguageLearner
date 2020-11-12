<?php
class WordTranslRel
{
    private $db;
    private $table = "word_transl_rel";

    public $wordId;
    public $translationId;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllWordsByTranslationId($translId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE translationId = " . $translId;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAllTranslationsByWordId($wordId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE wordId = " . $wordId;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
