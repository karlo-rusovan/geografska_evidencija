<?php 
    session_start();
    include_once('database.php');
    $pdo = database_connect();    
    $result_regions = $pdo->query("SELECT DISTINCT region FROM territories");
    $user_id = $_SESSION['user_id'];
?>
<!doctype html>
<html lang=”en”> 
<head> 
    <title>Locations visited by region</title> 
    <meta charset=”utf-8"> 
    <link rel="stylesheet" href="style.css" />    
</head> 
<body>
    <?php include('nav.php'); ?>
    <table class="statistics">
        <thead>
            <tr>
                <th class='statistics-head'>Region</th>
                <th class='statistics-head'>Cities visited by you</th>
                <th class='statistics-head'>Cities visited by all users</th>
            </tr>
        </thead>
        <tbody>
            <div id="stat-buttons">
                <a href="statistics-region.php"><button disabled class="stat-button" type="button">Visited by region</button></a>
                <a href="statistics-year.php"><button class="stat-button" type="button">Visited by year</button></a>
            </div>
            <?php
                foreach($result_regions AS $row){
                    if($row['region'] != null){
                        $result_cities_all = $pdo->query("SELECT world_cities.city_name FROM territories, world_cities
                        INNER JOIN visited_locations ON world_cities.gid = visited_locations.city_id
                        WHERE st_within(world_cities.geom,territories.geom) AND territories.region = '{$row['region']}'");
                        $result_cities_user = $pdo->query("SELECT world_cities.city_name FROM territories, world_cities
                        INNER JOIN visited_locations ON world_cities.gid = visited_locations.city_id
                        WHERE st_within(world_cities.geom,territories.geom) AND territories.region = '{$row['region']}'
                        AND visited_locations.user_id = {$user_id}");
                        echo "<tr><td id='statistics-body'>
                        <a class='statistics-link' href='index.php?region={$row['region']}'>{$row['region']}</a></td>
                        <td>{$result_cities_user->rowCount()}</td><td>{$result_cities_all->rowCount()}<td></tr>";
                    }
                }
            ?>
        </tbody>
    </table>
    <?php include('footer.php'); ?>
<body>