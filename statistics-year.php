<?php 
    session_start();
    include_once('database.php');
    $pdo = database_connect();    
    $user_id = $_SESSION['user_id'];
    $result_years = $pdo->query("SELECT DISTINCT EXTRACT('Year' FROM visited_locations.visit_date) as year FROM visited_locations WHERE
    visited_locations.user_id = {$user_id}");
    $datapoints = array();
    foreach($result_years AS $row){
        $year = $row['year'];
        $result_visits = $pdo->query("SELECT DISTINCT city_id FROM visited_locations WHERE visited_locations.user_id = {$user_id}
        AND EXTRACT('Year' FROM visited_locations.visit_date) = {$year}");
        $number_of_visits = $result_visits->rowCount();
        $datapoint = ["label"=>$year,"y"=>$number_of_visits];
        array_push($datapoints,$datapoint);
    }   
?>
<!doctype html>
<html lang=”en”> 
<head> 
    <title>Locations visited by region</title> 
    <meta charset=”utf-8"> 
    <link rel="stylesheet" href="style.css" /> 
    <script>
        window.onload = function () {        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", 
            title:{
                text: "Number of cities visited each year"
            },
            axisY:{
                includeZero: true
            },
            data: [{
                type: "column", 
                click: onClick,
                indexLabel: "{y}", 
                indexLabelFontColor: "#5A5757",
                indexLabelPlacement: "outside",   
                dataPoints: <?php echo json_encode($datapoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        function onClick(e) {
            location.href = "index.php?year=" + e.dataPoint.label; 
        }
    }
</script>   
</head> 
<body>
    <?php include('nav.php'); ?>
    <div id="stat-buttons">
        <a href="statistics-region.php"><button  class="stat-button" type="button">Visited by region</button></a>
        <a href="statistics-year.php"><button disabled class="stat-button" type="button">Visited by year</button></a>
    </div>    
    <div id="chartContainer" style="height: 370px; width: 60%; margin:auto; padding-top:30px"></div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <br>
    <div id="click-on-map">click on the columns to see cities visited in that year<div>
    <?php include('footer.php'); ?>
<body>