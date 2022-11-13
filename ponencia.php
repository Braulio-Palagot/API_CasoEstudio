<?php
include "config.php";
include "utils.php";
$dbConn = connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = $_GET;
    $codigo = $input['ID_Ponencia'];
    $fields = getParams($input);

    $sql = "UPDATE ponencia SET $fields WHERE ID_Ponencia = $codigo";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    var_dump($statement);
    header("HTTP/1.1 200 OK");
    exit();
}
?>