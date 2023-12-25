<?php 
    session_start();
    include_once('database.php');
    $pdo = database_connect();
    $result_size = $pdo -> query("SELECT DISTINCT pop_class, pop_rank FROM world_cities");   
    if(isset($_GET['submit'])){
        if(!empty($_GET['date-from'])){
            $date_from = date('Y-m-d',strtotime($_GET['date-from']));
        } else {
            $date_from = "1900-01-01";            
        }

        if(!empty($_GET['date-to'])){
            $date_to = date('Y-m-d',strtotime($_GET['date-to']));
            
        } else {
            $date_to = "3000-01-01";
        }
        $city_size = $_GET['city-size'];
        header("Location:index.php?city-size={$city_size}&date-from={$date_from}&date-to={$date_to}"); 
    }
?>   

<!doctype html>
<html lang=”en”> 
<head> 
    <title>Visited locations</title> 
    <meta charset=”utf-8"> 
    <link rel="stylesheet" href="style.css" />
    <meta name=”viewport” content=”width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map {
            margin-top: 20px;
            height: 100vh; 
        }
    </style>
</head> 
<body>
    <?php include('nav.php') ?>
    <form id="filter" name="filter_locations" method="GET" action="index.php">
        <div>
            <label for='city-size'>Filter by city size</label><br>
            <select id="city-size" name="city-size" required>
               <?php                
                    foreach($result_size as $row){
                        echo "<option value='{$row['pop_rank']}'>{$row['pop_class']}</option>";
                    }                            
               ?>
               <option value="all" selected>All sizes</option>
            </select><br><br>
            <label for='date-from'>Filter by date visited</label><br>
            <input class="date_input" type="text" name="date-from" placeholder="From date dd-mm-YYYY"/>
            <input class="date_input" type="text" name="date-to" placeholder="To date dd-mm-YYYY"/>
            <br><br>
            <input class="submit" id="filter_submit" type="submit" name="submit" value="Filter"></input>
        </div>        
    </form>      
    <div id="map"></div>
    <script>
        var mymap = L.map('map').setView([0,0],2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(mymap);

        var params = window.location.search.substr(1);
        console.log(params);
        $.ajax({url:`fetch_visited_locations.php?${params}`,
            success:function(response){     
                console.log(`fetch_visited_locations.php?${params}`);      
                jsnPoints = JSON.parse(response);
                console.log(jsnPoints);
                lyrTest = L.geoJSON(jsnPoints).addTo(mymap);
            },
            error:function(xhr,status,error){
                alert("ERROR: " + error);
            }
        });
    </script>
   <?php include('footer.php') ?>
</body> 
</html>