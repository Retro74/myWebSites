<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php include_once("dbcon.php")?>

<?php
// SQL-spørringen

$sql = "SELECT COUNT(Webside) AS Antall, Webside FROM tbl_besokslogg GROUP BY Webside ORDER BY Antall DESC";

// Kjør spørringen og sett resultatet i datasettet

$datasett = $tilkobling->query($sql);

// Sjekk at spørringen var vellykket

if (!$datasett) {
    die("SQL-feil: " . $tilkobling->error);
}
?>
<!-- For hver rad i datasettet lager PHP en rad i HTML-tabellen
     med kolonner for feltene: Antall, Webside -->

<table border=1>
    <thead>
    <tr>
        <th>Antall</th>
        <th>Webside</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($rad = $datasett->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($rad["Antall"]); ?></td>
            <td><?php echo htmlspecialchars($rad["Webside"]); ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>


</body>
</html>