<?php
    include_once('database.php');
    $pdo = database_connect(); 
    session_start();
 
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $authenticate = false;

        if(isset($username) && !empty($username) && isset($password)
        && !empty($password)){            
            $result = $pdo->query("SELECT * FROM users WHERE
            username = '{$username}' AND password = '{$password}'");
            $rows = $result->fetchAll(); 
            if(!empty($rows)){
                $authenticate = true;
            }
        }    
        if($authenticate){    
            $_SESSION['user_id'] = $rows[0]['user_id'];
            $_SESSION['role'] = $rows[0]['role'];
            $_SESSION['username'] = $rows[0]['username'];
            header('Location: index.php');
        } else {
            header('Location: login.php?failed_attempt=1');
        }
    }   
?>