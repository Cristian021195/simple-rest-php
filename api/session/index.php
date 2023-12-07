<?php
require_once dirname(__FILE__,3)."/models/SessionManager.php";

header("Content-Type: application/json");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //echo json_encode($session->checkSession('id'));
    //echo json_encode($session->restrictions(['id', 'tipo','a']));
    echo json_encode(SessionManager::showSesions());
    //echo json_encode(SessionManager::unsetAll());
}else if($_SERVER['REQUEST_METHOD'] == 'POST'){

}else if($_SERVER['REQUEST_METHOD'] == 'PUT'){

}else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

}

?>