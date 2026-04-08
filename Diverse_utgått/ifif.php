<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tilgang</h1>

    <?php
    $db_connection = new mysqli("localhost", "root", "", "db_nvgs");

    if (isset($_POST["submit"])) {
        $stmt = db_connection->prepare("SELECT * FROM elever WHERE Navn = ' . $_POST[navn] . '");
        $stmt->execute();
        $datasett = $stmt->get_result();
        while ($rad = mysqli_fetch_array($datasett)) {
            echo $rad["Navn"] . "<br>";
        }
    }
?>

</body>
</html>