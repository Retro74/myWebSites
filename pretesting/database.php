<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //Databasetilkobling, med databaseplassering, brukernavn, passord og databasenavn 
    $tilkobling = new mysqli("localhost","root","","db_mywebsite");
?>
<?php
    //SQL-spørringen 
    $sql = "SELECT * FROM tbl_gjestebok";
    //Kjører spørringen mot databasen og resultatet settes i datasettet 
    $datasett = $tilkobling->query($sql);
?>
<!-- For hver rad i datasettet, lager PHPkoden en rad i HTML-tabelen ,
med kolonner for feltene: bruker_id, innlegg, dato_tid-->
<table>
    <tr>
        <th>Bruker_id</th>
        <th>Innlegg</th>
        <th>Dato_tid</th>
    </tr>
    <?php while($rad = mysqli_fetch_array($datasett)) { ?>
        <tr>
            <td><?php echo $rad["bruker_id"]; ?></td>
            <td><?php echo $rad["innlegg"]; ?></td>
            <td><?php echo $rad["dato_tid"]; ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>