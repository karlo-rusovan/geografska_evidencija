<?php
    session_start();
    include_once('database.php');
    $pdo = database_connect();
    $user_id = $_SESSION['user_id'];    

    if(isset($_GET['year'])){
        $year = $_GET['year'];
        $result = $pdo->query("SELECT DISTINCT world_cities.*, ST_AsGeoJSON(world_cities.geom,5) AS geojson
        FROM visited_locations INNER JOIN world_cities ON visited_locations.city_id = world_cities.gid
        WHERE visited_locations.user_id = {$user_id}
        AND EXTRACT('Year' FROM visited_locations.visit_date) = {$year}");
        
    } else if(isset($_GET['region'])){
        $region = urldecode($_GET['region']);
        $result = $pdo -> query("SELECT world_cities.*, ST_AsGeoJSON(world_cities.geom,5) AS geojson FROM territories, world_cities INNER JOIN visited_locations ON 
        world_cities.gid = visited_locations.city_id WHERE visited_locations.user_id = {$user_id} 
        AND st_within(world_cities.geom,territories.geom) AND territories.region = '{$region}'");       
        $result_region = $pdo -> query("SELECT *, ST_AsGeoJSON(geom,5) AS geojson FROM territories WHERE region = '{$region}'"); 

    } else if (isset($_GET['city-size'])){     
        $date_from = $_GET['date-from'];
        $date_to = $_GET['date-to'];

        if($_GET['city-size'] != "all"){
            $pop_rank = $_GET['city-size'];                       
            $result = $pdo -> query("SELECT world_cities.*, ST_AsGeoJSON(geom,5) AS geojson FROM world_cities INNER JOIN visited_locations ON 
            world_cities.gid = visited_locations.city_id WHERE visited_locations.user_id = {$user_id} 
            AND world_cities.pop_rank = '{$pop_rank}' AND visited_locations.visit_date BETWEEN '{$date_from}' AND '{$date_to}'");
        } else {
            $result = $pdo -> query("SELECT world_cities.*, ST_AsGeoJSON(geom,5) AS geojson FROM world_cities INNER JOIN visited_locations ON 
            world_cities.gid = visited_locations.city_id WHERE visited_locations.user_id = {$user_id} 
            AND visited_locations.visit_date BETWEEN '{$date_from}' AND '{$date_to}'");
        }
        
    } else {
        $result = $pdo -> query("SELECT world_cities.*, ST_AsGeoJSON(geom,5) AS geojson FROM world_cities INNER JOIN visited_locations ON 
        world_cities.gid = visited_locations.city_id WHERE visited_locations.user_id = {$user_id}");
    }  
    
    $features =[];
    foreach($result AS $row) {
        unset($row['geom']);
        $geometry = $row['geojson'] = json_decode($row['geojson']);
        unset($row['geojson']);
        $feature = ["type"=>"Feature","geometry"=>$geometry,"properties"=>$row]; 
        array_push($features,$feature);
    }

    if(isset($result_region)){
        foreach($result_region AS $row) {
            unset($row['geom']);
            $geometry = $row['geojson'] = json_decode($row['geojson']);
            unset($row['geojson']);
            $feature = ["type"=>"Feature","geometry"=>$geometry,"properties"=>$row]; 
            array_push($features,$feature);
        } 
    }
    
    $featureCollection=["type"=>"FeatureCollection","features"=>$features];
    echo json_encode($featureCollection);
    //header('Location:index.php');
?>

