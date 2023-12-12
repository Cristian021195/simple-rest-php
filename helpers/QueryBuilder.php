<?php 
class QueryBuilder{
    public $raw_query;
    public $table;
    public $fields;
    public $nested_tables;
    public $where_conditions;
    public $having_conditions;
    public $group_by_conditions;
    public $limit_conditions;
    public $order_by_conditions;
    public $raw_sub_queries;
    public $obj_list_properties = [];
    public static function QInsert(){

    }
    public static function QCreate(){

    }
    public static function QRead(){
        
    }
    public static function QDelete(){
        
    }
    public static function QTuncate(){
        
    }
    public static function QUpdate(){
        
    }
    public static function QCommitTransaction(){
        
    }
    public static function QRollbackTransaction(){
        
    }
    public static function QArrayPropertiesSO($obj){
        $arr = [];
        foreach ((array)$obj as $k => $v){
            if($k != "props"){
                array_push($arr, [$k=>$v]);
            }            
        }
        self::$obj_list_properties = $arr;
    }

    public static function QArrayPropertiesMO($objs){
        $arr = [];
        foreach ($objs as $key => $obj) {
            foreach ((array)$obj as $k => $v){
                if($k != "props"){
                    array_push($arr, [$k=>$v]);
                }
            }    
        }        
        self::$obj_list_properties = $arr;
    }


    // metodos privados solo para dentro de esta clase
    private function inlineConditions($arrcond){//$ar = ["AND"=>["codigo"=>[1,2]], "OR"=>["nombre"=>["Planeta","Emece"]]];
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
    private function limit($min, $max){
        $q = "LIMIT ".$max." OFFSET ".$min;
        return $q;
    }
    
}

?>