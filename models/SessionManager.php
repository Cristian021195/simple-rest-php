<?php
session_start();
class SessionManager{
    private static $allowed_roles = ["admin"=>1, "supervisor"=>2, "ingresador"=>3,"pasante"=>4, "visitante"=>5];
    public function __construct(){
        //$this->allowed_roles = ["administrador"=>1, "supervisor"=>2, "ingresador"=>3,"pasante"=>4, "visitante"=>5];
    }
    public function __destruct(){}
    public static function showSesions(){
        return $_SESSION;
    }
    public static function checkSession($k){
        if(isset($_SESSION[$k])){
            return ["error"=>false,"mensaje"=>"ok"];
        }else{
            return ["error"=>true,"mensaje"=>"bad"];
        }
    }
    public static function restrictions($arr){// ['id','tipo','rol','estado'] - usado como middleware
        $f = false;
        foreach ($arr as $k => $v) {
            if(isset($_SESSION[$v])){
                $f = true;
            }else{
                $f = false; break;
            }
        }
        if($f == true){
            return ["error"=>false,"mensaje"=>"ok"];
        }else{
            return ["error"=>true,"mensaje"=>"no tiene los permisos necesarios"];
        }
    }
    public static function revalidate($k, $q, $v){// key query val - for only one session
        if(isset($_SESSION[$k])){
            echo json_encode(["error"=>false,"mensaje"=>"ok"]);
        }else{
            echo json_encode(["error"=>true,"mensaje"=>"bad"]);
        }
    }
    public static function revalidateMany($k, $q, $v){// keys[] query val[] - for only one session
        if(isset($_SESSION[$k])){
            echo json_encode(["error"=>false,"mensaje"=>"ok"]);
        }else{
            echo json_encode(["error"=>true,"mensaje"=>"bad"]);
        }
    }
    public static function unsetAll(){
        session_unset();
        session_destroy();
        return ["error"=>false, "mensaje"=>"sesiones cerradas!"];
    }
    public static function unsetSpecific($k){
        unset($_SESSION[$k]);
        return ["error"=>false, "mensaje"=>"sesion $k cerrada!"];
    }
    public static function allowedRole($s){
        $tipo = null; $exit = false;
        foreach (self::$allowed_roles as $k => $v) {
            if($k == $s) break;
        }        
        
        if(isset($_SESSION['tipo'])){
            $tipo = $_SESSION['tipo'];
            if($s == $tipo && $exit == false){
                return true;
            }else{
                http_response_code(403);
                echo json_encode(["error"=>true, "mensaje"=>"No autorizado!"]);
                exit;
            }
        }
    }
    public static function allowedRoles($roles){
        $tipo = null; $cont = 0;
        try {            
            foreach ($roles as $kr => $vr) {
                foreach (self::$allowed_roles as $k => $v) {
                    if($vr == $k){
                        $cont++;
                        break;
                    }
                }
            }

            if(count($roles) == $cont){
                $tipo = null; $eval = false;
                if(isset($_SESSION['tipo'])){
                    $tipo = $_SESSION['tipo'];
                    foreach ($roles as $k => $v) {
                        if($tipo == $v){
                            $eval = true;
                            break;
                        }
                    } 
                }
                if($eval){
                    return true;
                }else{
                    throw new Exception("", 1);    
                }                

            }else{
                throw new Exception("Los roles ingresados estan incorrectos o desactualizados", 1);
            }
        } catch (\Throwable $th) {
            http_response_code(403);
            echo json_encode(["error"=>true, "mensaje"=>"No autorizado, ".$th->getMessage()]);
            exit;
        }
    }
}

?>
