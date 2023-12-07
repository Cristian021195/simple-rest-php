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