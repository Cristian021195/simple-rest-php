<?php
require_once "DB.php";

class Usuario extends DB {
    public $id_usuario;
    public $mail;
    public $password;

    public function __destruct(){/*unset(StatusModel);*/}

    public function create(){
        return ["mensaje"=>"creado", "error"=>false, "status"=>200];
    }
    public function read(){
        if(!isset($this->conn)){
            $this->connectar();
        }

        
        $this->query = "SELECT id_usuario, mail, created_on, last_login, capital FROM usuarios;";
        try {
            
            $this->result = @pg_query($this->conn,$this->query);
            $this->columns = @pg_num_rows($this->result);
            if(!$this->result){
                throw new \Exception('Autogenerado!: '. pg_last_error());
                //return ["error"=>true,"msg"=>pg_last_error()];
            }
            $this->cerrar();
            while ($row = pg_fetch_assoc($this->result)) {
                $this->rows[] = $row;
            }
            return ["data"=>$this->rows, "columns"=>$this->columns, "error"=>false];
        } catch (\Throwable $th) {
            http_response_code(500);
            return ["error"=>true, "mensaje"=>$th];
            //throw new \Exception('Error de consulta!: '. pg_last_error());
        }
    }
    
}

?>
