<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "..\..\config\Database.php";
include "..\..\models\Word.php";
include "..\..\models\Translation.php";
include "..\..\models\WordTranslRel.php";

$database = new Database();
$db = $database->connect();

$word = new Word($db);
$result = $word->getAllWords();
$count = $result->rowCount();
if ($count > 0) {
    $words = array();
    $words["data"] = array();

    $relationDb = new WordTranslRel($db);
    $translationDb = new Translation($db);

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // var_dump($row);
        extract($row);
        $word_item = array(
          "id" =>$id,
          "spelling" => $spelling,
          "language" => $code,
          "translations" => array()
      );
        array_push($words["data"], $word_item);
    }

    echo json_encode($words);
} else {
    echo json_encode(array("message"=>"No words found"));
}
