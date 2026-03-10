<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
// Sjekk at forespørselen er POST


// Hent verdien fra POST-feltet og sjekk at den ikke er tom

$verdi = trim($_GET["txtx"] ?? "");
if ($verdi === "") {
    die("Feltet kan ikke være tomt.");
}

// Hash med Argon2id (mest anbefalt for passord)

// Inkluderer automatisk et tilfeldig salt

$hash = password_hash($verdi, PASSWORD_ARGON2ID);
echo($hash);
?>
    
</body>
</html>