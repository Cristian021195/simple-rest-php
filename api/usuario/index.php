<?php
require_once dirname(__FILE__,3)."/models/Usuario.php";
require_once dirname(__FILE__,3)."/models/SessionManager.php";
$usuario =  new Usuario();
header("Content-Type: application/json");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    
    //echo json_encode($usuario->read());
    //if(SessionManager::allowedRole('admin')){
    if(SessionManager::allowedRoles(['admin','ingresador'])){
        echo json_encode($usuario->read());
    }
    
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario->queries = [
        "UPDATE usuarios SET capital = capital - 1000 WHERE id_usuario = 5;",
        "UPDATE usuarios SET capital = capital + 1000 WHERE id_usuario = 19;"
    ];
    echo json_encode($usuario->runTransaction());
}else if($_SERVER['REQUEST_METHOD'] == 'PUT'){

}else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

}


?>