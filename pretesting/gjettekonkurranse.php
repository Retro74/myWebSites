<?php
$fasit = 137;
$melding = "";

// Postback: har brukeren sendt inn skjemaet?
if ($_POST) {
    $gjetning = (int)$_POST["tall"];

    if ($gjetning === $fasit) {
        $melding = "Riktig!";
    } else {
        $melding = "Feil, prøv igjen.";
    }
}
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Gjett antall erter – PHP</title>
</head>
<body>

<h2>Gjett antall erter i glasset (serverside PHP)</h2>

erter.jpg<br><br>

<form method="post">
    <input type="number" name="tall" placeholder="Skriv et tall">
    <button type="submit">Sjekk</button>
</form>

<p><?= $melding ?></p>

</body>
</html>