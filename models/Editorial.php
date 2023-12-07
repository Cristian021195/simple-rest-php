<?php
require_once "DB.php";

class Editorial extends DB {
    public $id;
    public $nombre;

    public function __destruct(){/*unset(StatusModel);*/}

    public function create(){
        return ["mensaje"=>"creado", "error"=>false, "status"=>200];
    }
    public function read(){
        if(!isset($this->conn)){
            $this->connectar();
        }
        $this->query = "SELECT * FROM editoriales;";
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

    public function readRange($min, $max){
        $q = $this->limit($min, $max);
        $this->query = "SELECT * FROM editoriales ".$q.";";
        if(!isset($this->conn)){
            $this->connectar();
        }
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
    
    public function readWithConditions($arr){
        if(!isset($this->conn)){
            $this->connectar();
        }
        $this->query = "SELECT * FROM editoriales ";        
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
