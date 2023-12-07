<?php
require_once "DB.php";

class Login extends DB {
    public $usuario;
    public $contra;
    public function __construct($user, $pass){
        $this->usuario = $user;
        $this->contra = $pass;
    }
    public function __destruct(){/*unset(StatusModel);*/}

    public function create(){
        return ["mensaje"=>"creado", "error"=>false, "status"=>200];
    }
    public function logIn(){ // chequear si ya hay sesion
        session_start();
        if($_SESSION == []){
            try {            
                $result = $this->rawQuery("SELECT * FROM usuarios WHERE mail = '$this->usuario';");
                if($result && $result['columns'] == 1){
                    if(password_verify($this->contra, $result['data'][0]['password'])){
                        $_SESSION['id'] = $result['data'][0]['id_usuario'];
                        $_SESSION['tipo'] = $result['data'][0]['tipo'];//eventualmente tipo, rol, estado
                        return ["error"=>false,"mensaje"=> "Login ok!"];
                    }else{
                        http_response_code(403);
                        return ["error"=>true,"mensaje"=> "Pass incorrecta!"];
                    }
                }else{
                    http_response_code(403);
                    return ["error"=>true,"mensaje"=> "No se encontró el usuario"];
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                return ["error"=>true,"mensaje"=>$th->getMessage()];
            }
        }else{
            return ["error"=>true,"mensaje"=>"con sessiones activas"];
        }
    }
    public function logOut(){
        session_start();
        session_unset();
        session_destroy();
        return ["error"=>false, "mensaje"=>"sesion cerrada, logout ok!"];
    }
    
}

?>
