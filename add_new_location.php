<?php  
    session_start();
    include_once('database.php');
    $pdo = database_connect();

    $result_countries = $pdo -> query("SELECT DISTINCT cntry_name FROM
    world_cities");

    $result_status = $pdo -> query("SELECT DISTINCT status FROM world_cities"); 

    if(isset($_POST['submit'])){
        $city_name = $_POST['city_name'];
        $admin_name = $_POST['admin_name'];
        $cntry_name = $_POST['cntry_name'];
        $status = $_POST['status'];
        $population = $_POST['pop'];
        $long = $_POST['longitude'];
        $lat = $_POST['latitude'];
        $pop_class = "";
        $pop_rank = "";

        switch (true) {
            case $population == 0:
                $pop_class = "";
                $pop_rank = 0;
                break;        
            case $population < 50000:
                $pop_class = "Less than 50,000";
                $pop_rank = 7;
                break;        
            case $population >= 50000 && $population <= 99999:
                $pop_class = "50,000 to 99,999";
                $pop_rank = 6;
                break;        
            case $population >= 100000 && $population <= 249999:
                $pop_class = "100,000 to 249,999";
                $pop_rank = 5;
                break;        
            case $population >= 250000 && $population <= 499999:
                $pop_class = "250,000 to 499,999";
                $pop_rank = 4;
                break;        
            case $population >= 500000 && $population <= 999999:
                $pop_class = "500,000 to 999,999";
                $pop_rank = 3;
                break;        
            case $population >= 1000000 && $population <= 4999999:
                $pop_class = "1,000,000 to 4,999,999";
                $pop_rank = 2;
                break;        
            case $population >= 5000000:
                $pop_class = "5,000,000 and greater";
                $pop_rank = 1;
                break;      
        }        

        $result_exists = $pdo -> query("SELECT * FROM world_cities
        WHERE city_name = '{$city_name}' AND admin_name = '{$admin_name}'
        AND cntry_name = '{$cntry_name}'");

        $row_exists = $result_exists -> fetchAll();

        if(!empty($row_exists)){
            header('Location:add_new_location.php?already_exists=1');
        } else {
            $pdo -> query("INSERT INTO world_cities (city_name, 
            admin_name, cntry_name, status, pop, geom, pop_class, pop_rank) VALUES 
            ('{$city_name}','{$admin_name}','{$cntry_name}',
            '{$status}',{$population},ST_GeomFromText('POINT({$long} {$lat})'),'{$pop_class}','{$pop_rank}')");
            header('Location:add_new_location.php?success=1');
        }        
    }        
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Karlo Rusovan">       
        <title>Add a new city</title>    
        <link rel="stylesheet" href="style.css" />    
    </head>
    <body>
        <?php include('nav.php') ?>
        <h1>Add a new city</h1>
        <form name="add_city" method="POST" action="add_new_location.php">
            <div>
            <label for="city_name">English name</label>
            <input type="text" name="city_name" size="30" required /></div>
            <div>
            <label for="admin_name">Local name</label>
            <input type="text" name="admin_name" size="30" required />
            </div>
            <div>
            <label for="pop">Population</label>
            <input type="number" name="pop" size="30" required />
            </div>
            <div>
            <label for="cntry_name">Country name</label><br>   
            <select id="cntry_name" name="cntry_name" required>
               <?php                
                    foreach($result_countries as $row){
                        echo "<option value='{$row['cntry_name']}'>{$row['cntry_name']}</option>";
                    }                            
               ?>
            </select>
            </div>
            <div>
            <label for="status">Status</label>   
            <select id="status" name="status" required>
               <?php                
                    foreach($result_status as $row){
                        echo "<option value='{$row['status']}'>{$row['status']}</option>";
                    }                            
               ?>
            </select>
            </div>
            <div>
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" size="30" required />
            </div>
            <div>
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" size="30" required />
            </div>
            <div><input class="submit" type="submit" name="submit" size="12" value="Add a city"/></div>
            <?php if(isset($_GET['already_exists'])){
                echo"<div class='alert'>This city already exists</div>";
            } else if (isset($_GET['success'])){
                echo"<div class='alert'>City added successfully</div>";
            }
            ?>
        </form>      
        <?php include('footer.php') ?>        
    </body>
</html>