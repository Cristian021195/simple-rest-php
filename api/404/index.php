<?php 
    http_response_code(404);
    header("Content-Type: application/json");
    echo json_encode(["error"=>true, "mensaje"=>"Recurso no encontrado, url inexistente"]);
?>