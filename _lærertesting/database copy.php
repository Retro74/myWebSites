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
    $sql = "SELECT * FROM tbl_brukere where brukernavn = 'bruker1'";
    //Kjører spørringen mot databasen og resultatet settes i datasettet 
    $datasett = $tilkobling->query($sql);

$rad = mysqli_fetch_array($datasett);
echo $rad["bruker_id"];

echo $rad["passord_hash"];


if (password_verify('abc123', $rad["passord_hash"])) {
    echo "Passordet er riktig.";
} else {
    echo "Feil passord.";
}


?>

</body>
</html>