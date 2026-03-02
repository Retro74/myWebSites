<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Mottak og lagring av data</h1>
    <p>
        Tatt imot navn: <?php echo($_POST["txt_navn"]) ?> <br>
        Tatt imot alder: <?php echo($_POST["num_alder"]) ?> <br>
        <?php 
        $_SESSION["navn"] = $_POST["txt_navn"];
        $_SESSION["alder"] = $_POST["num_alder"];
        echo("Og lagret navn i SESSION['navn']: " . $_SESSION["navn"] . "<br> 
            samt alder i SESSION['alder']: " . $_SESSION['alder'])
        ?>

    </p>
<a href="oppg1_vis.php">Link til Side 3</a>
</body>
</html>