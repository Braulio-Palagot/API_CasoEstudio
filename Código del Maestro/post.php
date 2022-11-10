<?php
include "config.php";
include "utils.php";
$dbConn =  connect($db);

/*
  listar todos los  o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['codigo']))
    {
      //Mostrar una categoria
      $sql = $dbConn->prepare("SELECT * FROM categoria where codigo=:codigo");
      $sql->bindValue(':codigo', $_GET['codigo']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }
    else {
      //Mostrar lista de categorías
      $sql = $dbConn->prepare("SELECT * FROM categoria");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO categoria (codigo, nombre) VALUES (codigo, 'nombre');"; //Falta recibir parametro...
	
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if($postId)
    {
      $input[':codigo'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
	 }
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $codigo = $input['codigo'];
    $fields = getParams($input);
	
	$sql = "UPDATE categoria SET $fields WHERE codigo = $codigo";
	
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
  $idCat = $_GET['codigo'];
  $statement = $dbConn->prepare("DELETE FROM categoria where codigo=:codigo");
  $statement->bindValue(':codigo', $idCat);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

//Prueba: http://localhost/webService/post.php
?>