<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "..\..\config\Database.php";
include "..\..\models\Translation.php";
include "..\..\models\WordTranslRel.php";
include "..\..\models\Word.php";

$database = new Database();
$db = $database->connect();

$translationDb = new Translation($db);
$translationsResult = $translationDb->getAllTranslationsByLanguage(2);
$count = $translationsResult->rowCount();
if ($count > 0) {
    $response = array();
    $response["data"] = array();

    $relationDb = new WordTranslRel($db);
    $wordDb = new Word($db);

    while ($translRow = $translationsResult->fetch(PDO::FETCH_ASSOC)) {
        extract($translRow);
        $translation = array(
            "id" =>$id,
            "spelling" => $spelling,
            "pronunciation" => $pronunciation,
            "language" => $code,
            "words" => array()
        );

        $relResult = $relationDb->getAllWordsByTranslationId($id);
        $relations = $relResult->fetchAll(PDO::FETCH_ASSOC);
        foreach($relations as $rel) {
          $wordsResult = $wordDb->getWordById($rel["wordId"]);
          while ($wordRow = $wordsResult->fetch(PDO::FETCH_ASSOC)) {
              extract($wordRow);
              array_push($translation["words"], $wordRow["spelling"]);
          }
        }
        array_push($response["data"], $translation);
    }
    echo json_encode($response);
} else {
    echo json_encode(array("message"=>"No translations found"));
}
