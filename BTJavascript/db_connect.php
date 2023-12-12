<?php
    try{
        $conn = new mysqli("localhost","root","","BTTH02_1");
    }catch(Exception $e){
        echo $e->getMessage();
    }

?>