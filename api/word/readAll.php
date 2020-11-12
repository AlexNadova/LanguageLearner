<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "..\..\config\Database.php";
include "..\..\models\Word.php";

$database = new Database();
$db = $database->connect();

$word = new Word($db);
$result = $word->getAllWords();
$count = $result->rowCount();
if ($count > 0) {
    $words = array();
    $words["data"] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $word_item = array(
          "id" =>$id,
          "spelling" => $spelling,
          "language" => $code
      );
        array_push($words["data"], $word_item);
    }

    echo json_encode($words);
} else {
    echo json_encode(array("message"=>"No words found"));
}
