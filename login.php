<?php  
    session_start();

    if(isset($_GET["logout"])){
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        unset($_SESSION['user_id']);
        session_destroy();
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Karlo Rusovan">       
        <title>Add a new visited city</title>    
        <link rel="stylesheet" href="style.css" />    
    </head>
    <body>
        <?php include('nav.php') ?>
        <h1>Log In</h1>
        <form name="login" method="POST" action="authenticate.php">
            <div>
            <label for="username">Username</label>
            <input type="text" name="username" size="30" placeholder="username"/></div>
            <div>
            <label for="password">Password</label>
            <input type="password" name="password" size="30" placholder="password" /></div>
            <div id="signup"><a href="sign_up.php">Sign Up</a></div>
            <div><input class="submit" type="submit" name="submit" size="12" value="Login"/></div>
            <?php
                if(isset($_GET['failed_attempt'])){
                    echo "<div class='alert'>Incorrect username or password</div>";
                } else if (isset($_GET['logout'])){
                    echo "<div class='alert'>Log out successful</div>";
                }
            ?>        
        </form>
        <?php include('footer.php') ?>        
    </body>
</html>