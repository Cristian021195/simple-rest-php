<?php
require_once dirname(__FILE__,3)."/models/Editorial.php";

$editorial = new Editorial();

header("Content-Type: application/json");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //echo json_encode($editorial->read());
    //echo json_encode($editorial->readRange(0,2));
    //echo json_encode($editorial->rawQuery("SELECT nombre FROM editoriales ".$editorial->inlineConditions(["AND"=>["codigo"=>[1,2]]])." ".$editorial->limit(1,2)));

    //echo json_encode("SELECT * FROM editoriales ". $editorial->inlineConditions(["AND"=>["codigo"=>[1,2]], "OR"=>["nombre"=>["Planeta","Emece"]]]));

    //echo json_encode($editorial->rawQuery("SELECT * FROM editoriales;"));

    //$ar = [["codigo"=>[1,2], "nombre"=>["Planeta","Emece"]]];
    echo json_encode($editorial->readRange(1,2));

}else if($_SERVER['REQUEST_METHOD'] == 'POST'){

}else if($_SERVER['REQUEST_METHOD'] == 'PUT'){

}else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

}

//header("Content-Type: application/json");
//echo json_encode($editorial->read());

?>