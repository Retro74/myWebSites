<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viser verdier fra Sessions</title>
</head>
<body>
    <h1>Henter og viser verdier i $_SESSION["navn"] og $_SESSION["alder"]</h1>
    <?php 
        echo("SESSION['navn'] inneholder: " . $_SESSION["navn"] . "<br> 
            SESSION['alder'] inneholder: " . $_SESSION['alder'])
        ?>


<p id="p_jsresult">
<script>
    // utfordring
    p_jsresult.innerHTML = "Om 5 år er du " + (<?php echo($_SESSION['alder']) ?> + 5) + " år."

</script>
</body>
</html>