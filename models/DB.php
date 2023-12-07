<?php
ini_set('html_errors', false);
require_once dirname(__FILE__,2)."/config/env.php";
include dirname(__FILE__,2)."/helpers/parserTipo.php";
header("Access-Control-Allow-Origin: http://localhost:5500");

class DB
{
    public $conn; 
    public $rows = [];
    public $query;
    public $queries = [];
    public $result;
    public $resource;
    public $columns = 0;
    public $limit_a = 0;
    public $limit_b = 0;
    public $conditions = [];

    public function __construct(){
      if(!isset($this->conn)){
        //$this->conn = pg_connect("host='localhost' port='5432' user='postgres' password='admin' dbname='ejemplo' options='--client_encoding=UTF8'") or die('No pudo conectarse: ' . pg_last_error());
        $this->conn = pg_connect("host=".$_ENV['DB_HOST']." port=".$_ENV['DB_PORT']." user=".$_ENV['DB_USER']." password=".$_ENV['DB_PASS']." dbname=".$_ENV['DB_NAME']." options=".$_ENV['DB_OPT']."") OR die('No pudo conectarse: ' . pg_last_error());
      }
    }

    public function connectar(){
        if(!isset($this->conn)){
            //$this->conn = pg_connect("host='localhost' port='5432' user='postgres' password='admin' dbname='ejemplo' options='--client_encoding=UTF8'") or die('No pudo conectarse: ' . pg_last_error());
            $this->conn = pg_connect("host=".$_ENV['DB_HOST']." port=".$_ENV['DB_PORT']." user=".$_ENV['DB_USER']." password=".$_ENV['DB_PASS']." dbname=".$_ENV['DB_NAME']." options=".$_ENV['DB_OPT']."") OR die('No pudo conectarse: ' . pg_last_error());
            return $this->conn;
        }
        return $this->conn;
    }

    public function cerrar(){
        try {
            if(isset($this->conn)){
                if(pg_close($this->conn) == false){
                    throw new \Exception('¡Error al cerrar la conexion!');
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function limit($min, $max){
        $q = "LIMIT ".$max." OFFSET ".$min;
        return $q;
    }

    public function inlineConditions($arrcond){//$ar = ["AND"=>["codigo"=>[1,2]], "OR"=>["nombre"=>["Planeta","Emece"]]];
        $this->conditions = $arrcond;
        $q = "WHERE ";

        foreach ($this->conditions as $clause => $field){
            foreach ($field as $ks => $vs) {
                foreach ($vs as $k => $v) {
                    //$q.="".$ks."=".$v." ".$clause." ";
                    $q.="".$ks."=".parserTipo($v)." ".$clause." ";
                }   
            }
        }
        $q = substr($q,0,-4);
        $this->conditions = [];
        return $q;
    }

    public function rawQuery($query){
        if(!isset($this->conn)){
            $this->connectar();
        }
        $this->query = $query;
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
        }
    }

    function createTransaction(){
        $exit = false;
        $exec_res = null;
        $response = [];
        try {
            if(!isset($this->conn)){
                $this->connectar();
            }
            $exec_res = @pg_query($this->conn,"BEGIN;");
            if(!$exec_res){
                throw new \Exception('Error al iniciar la transacción!: '. pg_last_error());
            }
            foreach ($this->queries as $k => $v) {//consultas separadas por coma
                $this->result = @pg_query($this->conn,$v);
                $this->columns = @pg_num_rows($this->result);
                if(!$this->result){
                    $exit = true;
                    break;
                }
            }
            if($exit == true){                
                $exec_res = @pg_query($this->conn,"ROLLBACK;");
                if(!$exec_res){
                    throw new \Exception('Error al cerrar la transacción!: '. pg_last_error());
                }
                http_response_code(500);
                $response = ["error"=>true, "mensaje"=>"Error en la transaccion"];
            }else{
                $exec_res = @pg_query($this->conn,"COMMIT;");
                if(!$exec_res){
                    throw new \Exception('Error al cerrar la transacción!: '. pg_last_error());
                }
                $response = ["error"=>false, "mensaje"=>"Transaccion ok"];
            }
            
        } catch (\Throwable $th) {
            $exec_res = @pg_query($this->conn,"ROLLBACK;");
            http_response_code(500);
            $response = ["error"=>true, "mensaje"=>$th];
        }        
        $this->cerrar();
        return $response;
    }
    

    /*
    
    function cargandoAsignacionEstadoCarga($idEstadoCampo)
	{
		$conexion = new Conexion();
		$conexion->consulta("Begin;");
		$resultado1 = $conexion->consulta("UPDATE asignacion_estado_carga SET estado='Cargando'
							 WHERE idestado_campo = $idEstadoCampo;");
		$resultado2 = $conexion->consulta("UPDATE estado_campo SET estado='Cargando' 
							 WHERE idestado_campo = $idEstadoCampo;");

		if($resultado1 && $resultado2){
			$resultado = true;
			$conexion->consulta('COMMIT');
		}else{
			$resultado = false;
			$conexion->consulta('ROLLBACK');
		}
		$conexion->close();
		return $resultado;
	}
    
    */

}