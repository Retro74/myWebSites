<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sjekk tilgang</title>
</head>
<body>
    <h1>Sjekker tilgang</h1>
    
    <?php 
    if ($_POST["bokstav1"] . $_POST["bokstav2"] . $_POST["bokstav3"] == "AEA"){
        echo("Gyldig accesscode");
        $_SESSION["tilgang"] = "OK";
        header("Location: oppg2_hemmelig.php");
        exit;

        
    }else{
        echo("Ugyldig accesscode");
        $_SESSION["feilmelding"] = "Ugyldig tilgangskode";
        $_SESSION["tilgang"] = "";

        //header("Location: oppg2_inngang.php");
        //exit;

    }

    ?>
</body>
</html>