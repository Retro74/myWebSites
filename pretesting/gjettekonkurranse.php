<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php 
        if ($_POST) {
            $_SESSION["harGjettet"] = True;
            if ($_POST["num_erter"] == 367){ ?>
                <img src="images/winner.jpg"> 
            <?php 
            } else { ?>
                <img src="images/youLoose.jpg"> 
            
            <?php
            }
        } else {
            if (!isset($_SESSION["harGjettet"])) {
    ?>

    <h1>Gjett antall erter i glasset (PHP- Server side)</h1>
    <img src="images/pea_jar2.png">
    <form method="POST">
        <input type="number" name="num_erter" id="num_erter">
        <button type="submit">Gjett antall erter</button>
    </form>
    <?php } else { 


        echo("Du har gjettet før! Vent til i morgen."); 

        echo("<a href='removeSession.php'>Fjern session her</a>");
        
        }} ?>

</body>
</html>