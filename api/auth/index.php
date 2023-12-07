<?php
require_once dirname(__FILE__,3)."/models/Login.php";

$login = new Login("cristiangramajo015@gmail.com", "021195cd");

header("Content-Type: application/json");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo json_encode($login->logIn());
    //echo json_encode($login->logOut());
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){

}else if($_SERVER['REQUEST_METHOD'] == 'PUT'){

}else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

}

//header("Content-Type: application/json");
//echo json_encode($editorial->read());

?>