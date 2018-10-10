<?php
    /*Seems to compare the material to a list of set materials. I think that what this is doing is
    *determining which items turn red on materials.php - so this means that we will need to have it
    *pull from the database next time for the array. I will add a "verified" field to the database
    *of commodities before this happens so that it will only pull the database that are set from
    *the larger national databases (verified=true). I am about ninety-five percent sure that
    *Jared wrote this in its original form.
    *Also moving to app folder so I don't get confused and delete it thinking it was a stray file.
    *That happened once.
    */
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
