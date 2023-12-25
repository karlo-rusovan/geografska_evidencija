<?php  
    session_start();
    include_once('database.php');
    $pdo = database_connect();

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $password = $_POST['password'];

        $result = $pdo -> query("SELECT * FROM users WHERE username='{$username}'");
        $rows = $result -> fetchAll();
        if(!empty($rows)){
            header('Location: sign_up.php?already_exists=1');
        } else {
            $pdo -> query("INSERT INTO users (username, first_name,
            last_name, password, role) VALUES 
            ('{$username}', '{$first_name}', '{$last_name}',
            '{$password}','user')");
            header('Location: login.php');
        }
    }  
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Karlo Rusovan">       
        <title>Sign Up</title>    
        <link rel="stylesheet" href="style.css" />    
    </head>
    <body>
        <?php include('nav.php') ?>
        <h1>Sign Up</h1>
        <form name="login" method="POST" action="sign_up.php">
            <div>
            <label for="username">Username</label>
            <input type="text" name="username" size="30" required placeholder="username"/></div>
            <div>
            <label for="first_name">First name</label>
            <input type="text" name="first_name" size="30" required placeholder="First name"/>
            </div>
            <div>
            <label for="first_name">Last name</label>
            <input type="text" name="last_name" size="30" required placeholder="Last name"/>
            </div>
            <div>
            <label for="password">Password</label>
            <input type="password" name="password" size="30" required placholder="password" /></div>
            <div><input class="submit" type="submit" name="submit" size="12" value="Sign Up"/></div>
            <?php if(isset($_GET['already_exists'])){
                echo"<div class='alert'>Username already taken</div>";}
            ?>
        </form>      
        <?php include('footer.php') ?>        
    </body>
</html>