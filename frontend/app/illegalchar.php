<?php

namespace scservice;

//This will be used on multiple ares of the site to eliminate illegal characters from the usernames, passwords and other information, to help prevent SQL injections.

class illegalchars{

    private $charlist; 
    private $checkstring; 
    private $result;

public function findchars($chars, $input){
    foreach($chars as $char){
        if (strpos($input, $char) !== false) {
            return true;
        }
    }
    return false;
}

public setresult(){
    $result = $findchars($charlist, $checkstring);
}

public getresult(){
    return $result;
}
}

?>
