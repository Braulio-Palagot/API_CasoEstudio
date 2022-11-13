<?php
include "config.php";
include "utils.php";
$dbConn = connect($db);

/*
  listar todos los  o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['tabla'])) {
        if ($_GET['tabla'] == 'ponencia') {
            if (isset($_GET['idPonencia'])) {
                $sql = $dbConn->prepare("SELECT * FROM ponencia WHERE ID_Ponencia = :idvarPonencia;");
                $sql->bindValue(':idvarPonencia', $_GET['idPonencia']);
                $sql->execute();
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
                exit();
            } else {
                $sql = $dbConn->prepare("SELECT * FROM ponencia");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit();
            }
        } else if ($_GET['tabla'] == 'usuario') {
            if (isset($_GET['idUsuario'])) {
                $sql = $dbConn->prepare("SELECT * FROM usuario where ID_Usuario= :id_usuario;");
                $sql->bindValue(':id_usuario', $_GET['idUsuario']);
                $sql->execute();
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
                exit();
            } else {
                $sql = $dbConn->prepare("SELECT * FROM usuario");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit();
            }
        } else if ($_GET['tabla'] == 'evento') {
            if (isset($_GET['idEvento'])) {
                $sql = $dbConn->prepare("SELECT * FROM evento WHERE ID_Evento = :idEvento;");
                $sql->bindValue(':idEvento', $_GET['idEvento']);
                $sql->execute();
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
                exit();
            } else {
                $sql = $dbConn->prepare("SELECT * FROM evento");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit();
            }
        } else if ($_GET['tabla'] == 'comentario') {
            if (isset($_GET['idComentario'])) {
                $sql = $dbConn->prepare("SELECT * FROM comentario WHERE ID_Comentario=:idComentario;");
                $sql->bindValue(':idComentario', $_GET['idComentario']);
                $sql->execute();
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
                exit();
            } else {
                $sql = $dbConn->prepare("SELECT * FROM comentario");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit();
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tabla'])) {
        if ($_POST['tabla'] == 'ponencia') {
            $input = $_POST;
            $sql = "INSERT INTO ponencia (tema, documentacion, materialApoyo) VALUES (:varTema, :varDoc, :varMaterial);";

            $statement = $dbConn->prepare($sql);
            $statement->bindValue(':varTema', $input['tema']);
            $statement->bindValue(':varDoc', $input['documentacion']);
            $statement->bindValue(':varMaterial', $input['material']);
            $statement->execute();
            $postId = $dbConn->lastInsertId();
            if ($postId) {
                $input[':codigo'] = $postId;
                header("HTTP/1.1 200 OK");
                echo json_encode($input);
                exit();
            }
        } else if ($_POST['tabla'] == 'usuario') {
            $input = $_POST;
            $sql = "INSERT INTO usuario (nombreUsuario, Correo, apellidoPaternoUsuario, apellidoMaternoUsuario, contrasenia) VALUES (:nombre, :correo, :apPat, :apMat, :pass);";

            $statement = $dbConn->prepare($sql);
            $statement->bindValue(':nombre', $input['nombre']);
            $statement->bindValue(':correo', $input['correo']);
            $statement->bindValue(':apPat', $input['apellidoPat']);
            $statement->bindValue(':apMat', $input['apellidoMat']);
            $statement->bindValue(':pass', $input['password']);
            $statement->execute();
            $postId = $dbConn->lastInsertId();
            if ($postId) {
                $input[':codigo'] = $postId;
                header("HTTP/1.1 200 OK");
                echo json_encode($input);
                exit();
            }
        } else if ($_POST['tabla'] == 'evento') {
            $input = $_POST;
            $sql = "INSERT INTO evento (nombre,direccion,fecha) VALUES (:nombre,:direccion,:fecha);";

            $statement = $dbConn->prepare($sql);
            $statement->bindValue(':nombre', $input['nombre']);
            $statement->bindValue(':direccion', $input['direccion']);
            $statement->bindValue(':fecha', $input['fecha']);
            $statement->execute();
            $postId = $dbConn->lastInsertId();
            if ($postId) {
                $input[':codigo'] = $postId;
                header("HTTP/1.1 200 OK");
                echo json_encode($input);
                exit();
            }
        } else if ($_POST['tabla'] == 'comentario') {
            $input = $_POST;
            $sql = "INSERT INTO comentario (Comentario) VALUES (:comentario);";

            $statement = $dbConn->prepare($sql);
            $statement->bindValue(':comentario', $input['comentario']);
            $statement->execute();
            $postId = $dbConn->lastInsertId();
            if ($postId) {
                $input[':codigo'] = $postId;
                header("HTTP/1.1 200 OK");
                echo json_encode($input);
                exit();
            }
        }
    }
}

//Actualizar
// Se hizo uno por tabla

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['tabla'])) {
        if ($_GET['tabla'] == 'ponencia') {
            $id = $_GET['idPonencia'];
            $statement = $dbConn->prepare("DELETE FROM ponencia where ID_Ponencia=:codigo");
            $statement->bindValue(':codigo', $id);
            $statement->execute();
            header("HTTP/1.1 200 OK");
            exit();
        } else if ($_GET['tabla'] == 'usuario') {
            $id = $_GET['idUsuario'];
            $statement = $dbConn->prepare("DELETE FROM usuario where ID_Usuario=:codigo");
            $statement->bindValue(':codigo', $id);
            $statement->execute();
            header("HTTP/1.1 200 OK");
            exit();
        } else if ($_GET['tabla'] == 'evento') {
            $id = $_GET['idEvento'];
            $statement = $dbConn->prepare("DELETE FROM evento where ID_Evento=:codigo");
            $statement->bindValue(':codigo', $id);
            $statement->execute();
            header("HTTP/1.1 200 OK");
            exit();
        } else if ($_GET['tabla'] == 'comentario') {
            $id = $_GET['idComentario'];
            $statement = $dbConn->prepare("DELETE FROM comentario where ID_Comentario=:codigo");
            $statement->bindValue(':codigo', $id);
            $statement->execute();
            header("HTTP/1.1 200 OK");
            exit();
        }
    }
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
    header("HTTP/1.1 400 Bad Request");

//Prueba: http://localhost/api_casoestudio/post.php
    ?>