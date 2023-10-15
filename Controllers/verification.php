<?php

    function verification($table,$key){

        include_once("Database/database.php");

        $request1 = $bdd->query("SELECT $key FROM $table WHERE $key='$key'");
        
        return (!empty($request1) && $request1->rowCount()==1)? true:false;

    }

 ?>