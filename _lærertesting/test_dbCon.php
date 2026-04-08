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
// Sjekk tilkoblingsfeil

if ($tilkobling->connect_errno) {
    // Logg feilen på server - ikke vis detaljer til bruker

    error_log("Tilkoblingsfeil (" . $tilkobling->connect_errno . "): " . $tilkobling->connect_error);
    die("En feil oppstod. Vennligst prøv igjen senere.");
}

// Sjekk spørringsfeil

if ($tilkobling->errno) {
    // Logg feilen på server - ikke vis detaljer til bruker

    error_log("Spørringsfeil (" . $tilkobling->errno . "): " . $tilkobling->error);
    die("En feil oppstod. Vennligst prøv igjen senere.");
}
?>
</body>
</html>