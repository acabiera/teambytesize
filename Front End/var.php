<?php
	function contains($m){
		$materials = array("steel", "rubber", "iron ore", "copper", "cotton", "hard sawnwood");
		for($i = 0; $i < count($materials); $i++){
			if($m == $materials[$i]){
				return true;
			}
		}
		return false;
	}

?>
