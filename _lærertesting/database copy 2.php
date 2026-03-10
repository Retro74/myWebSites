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
// Forberedt spørring med flere parametere
$stmt = $tilkobling->prepare("SELECT * FROM tbl_brukere WHERE brukernavn = ? AND brukernavn = ?");
if(!$stmt){
    die("Prepare-feil: " . $tilkobling->error);
}

// Bind-verdier
$stmt->bind_param(
    "ss",
    $_POST["txt_brukernavn"],
    $_POST["txt_brukernavn"]
);

$stmt->execute();
$datasett = $stmt->get_result();

if(!$datasett){
    die("SQL-feil: " . $tilkobling->error);
}

$rad = mysqli_fetch_array($datasett);
echo $rad["brukernavn"];


?>

</body>
</html>