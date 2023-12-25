<?php
    function database_connect(){
        $dsn = "pgsql:host=localhost;dbname=sdb;port=5432";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false    
        ];
        $pdo = new PDO($dsn,'postgres','rusovan27',$opt);
        return $pdo;
    }
?>