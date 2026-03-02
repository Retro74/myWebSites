<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hemmlig side</title>
    
    <style>
        body {
            background-color: #000; /* svart bakgrunn */
            color: #00ff88; /* neon-grønn tekst */
            font-family: "Courier New", monospace; /* kode-font */
            text-shadow: 0 0 8px #00ff88; /* glødende effekt */
            padding: 40px;
        }

    </style>
</head>
<body>
<?php //Timeout-sjekk
$timeout = 10;

if (isset($_SESSION["lastActivity"])){
    if (time() - $_SESSION["lastActivity"] > $timeout) {
    // Timeout har skjedd
    unset($_SESSION["tilgang"]);
    unset($_SESSION["lastActivity"]);
    $_SESSION["feilmelding"] = "Tilgang time-out";
//    echo("Time-out");
    header("Location: oppg2_inngang.php ");
    exit();
    }}

// Oppdater aktivitetstidspunkt
$_SESSION["lastActivity"] = time();

?>

    <h1>Hemmeling handling</h1>
    <?php if ($_SESSION["tilgang"] == "OK") {
        //Tilgangskoden er sjekket og alt ok til å vise den hemmelige medlingen
        echo("<p>Du skal glemme alt. Skjønner?</p>");
    } else {
        //Tilgangskoden er ugyldig og sender brukeren tilbake
        $_SESSION["feilmelding"] = "Uautorisert tilgang";
        $_SESSION["tilgang"] = "";
        header("Location: oppg2_inngang.php");
        exit;
    } ?>
    <a href="oppg2_hemmelig.php">Se hva du skal huske her</a>
</body>
</html>