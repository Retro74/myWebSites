<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //Databasetilkobling, med databaseplassering, brukernavn, passord og databasenavn 
    $tilkobling = new mysqli("localhost","root","","db_mywebsite");
?>
<?php
    //SQL-spørringen 
    $sql = "SELECT * FROM tbl_brukere";
    //Kjører spørringen mot databasen og resultatet settes i datasettet 
    $datasett = $tilkobling->query($sql);
?>
<?php if($rad = mysqli_fetch_array($datasett)) { ?>
    brukernavn: <?php echo $rad["brukernavn"]; ?>
    passord: <?php echo $rad["passord_hash"]; ?>
<?php } else {?>
    <p>Tomt</p>
<?php } ?>
</body>
</html>