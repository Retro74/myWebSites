<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include_once("dbcon.php");
// SQL-spørringen

$sql = "SELECT DATE_FORMAT(Tidsstempel, '%Y-%m-%d') AS Dato, COUNT(*) As Antall FROM tbl_besokslogg GROUP BY Dato";

// Kjør spørringen og sett resultatet i datasettet

?>

    <script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Webstats-diagram"
	},
	data: [{        
		type: "line",
      	indexLabelFontSize: 16,
		dataPoints: [
<?php
    $datasett = $tilkobling->query($sql);
    while($rad = mysqli_fetch_array($datasett)){
        echo("{ x: new Date('" .  $rad["Dato"] . "'), y: " . $rad["Antall"] .  " },");
    } ?>
		]
	}]
});
chart.render();

}
</script>
<h2>Webstats</h2>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>