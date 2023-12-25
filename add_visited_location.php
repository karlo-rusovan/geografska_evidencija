<?php
    include_once('database.php');
    $pdo = database_connect(); 
    session_start();

    if(isset($_POST['submit'])){
        $user_id = $_SESSION['user_id'];
        $city_id = $_POST['city'];
        $date = date('Y-m-d',strtotime($_POST['date']));        
        $pdo -> query("INSERT INTO visited_locations VALUES 
        ($user_id,$city_id,'{$date}')");

        header("Location:index.php");
    }
    $result = $pdo -> query("SELECT * FROM world_cities");
?>

<!DOCTYPE html>
<html lang=hr>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Karlo Rusovan">        
        <title>Add a new visited city</title>    
        <link rel="stylesheet" href="style.css" />   
    </head>
    <body>
        <?php include('nav.php'); ?>
        <header> 
            <h1>Add a new visited city</h1>
        </header>        
        <form id="new_city" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
            <div>
            <label for="date">Date of visiting</label>
            <input type="date" required id="date" name="date"/></div>
            <div>
            <label for="city">City you visited</label>     
            <select id="city" name="city" required>
               <?php                
                    foreach($result as $row){
                        echo "<option value='{$row['gid']}'>{$row['city_name']}, {$row['cntry_name']}</option>";
                    }                            
               ?>
            </select></div>
           <div><input class="submit" type="submit" name="submit" value="Add location"/></div>
        </form>    
        <?php include('footer.php') ?>     
    </body>
</html>