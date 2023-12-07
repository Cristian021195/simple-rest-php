<?php
include "strContains.php";
include "validateDate.php";
function parserTipo($eval){
	if(is_null($eval)){
		return $eval;
	}else{
		if(is_int($eval)){
			return $eval;
		}else{
			if(strContains($eval, 'NULL') || strContains($eval, 'null')){
				return $eval;
			}else if($eval === "0"){
				return $eval;
			}else if(validateDate($eval, 'Y-m-d')){
				return "'".$eval."'";
			}else{
				$ceval = intval($eval);
				if($ceval === 0){
					return "'".$eval."'";
				}else{
					return $ceval;
				}
			}
		}
	}
}

?>