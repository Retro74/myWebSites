<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
// Databasetilkobling med server, brukernavn, passord og databasenavn

$tilkobling = new mysqli("localhost", "root", "", "db_mywebsite2");

// Sjekk at tilkoblingen var vellykket

if ($tilkobling->connect_error) {
    die("Tilkoblingsfeil: " . $tilkobling->connect_error);
}

?>
<?php
// Sjekk at forespørselen er POST




// Prepared statement - hent rad basert på ikke-hashede felter

// Passord verifiseres etterpå med password_verify()

$stmt = $tilkobling->prepare(
    "SELECT * FROM tbl_brukere WHERE brukernavn = ?"
);
if (!$stmt) {
    die("Prepare-feil: " . $tilkobling->error);
}

// Bind parametere fra POST-data

$stmt->bind_param("s",
    $_GET["txt_brukernavn"]
);

// Kjør spørringen og hent datasett

$stmt->execute();
$datasett = $stmt->get_result();
if (!$datasett) {
    die("SQL-feil: " . $tilkobling->error);
}

// Hent raden og verifiser passordet med password_verify()

$rad = $datasett->fetch_assoc();
if ($rad && password_verify($_GET["txt_passord"], $rad["Passord_hash"])) {
    // Gyldig brukernavn og passord

    echo("Gyldig brukernavn og passord");
} else {
    // Ugyldig brukernavn eller passord

    echo("Ugyldig brukernavn eller passord");
}
?>
</body>
</html>
