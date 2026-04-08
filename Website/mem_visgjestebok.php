<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php
    include_once("dbcon.php");
    include_once("statistikk.php");
// SQL-spørringen

$sql = "SELECT * FROM tbl_gjestebok WHERE Aktiv = 1";

// Kjør spørringen og sett resultatet i datasettet

$datasett = $tilkobling->query($sql);

// Sjekk at spørringen var vellykket

if (!$datasett) {
    die("SQL-feil: " . $tilkobling->error);
}
?>

<!-- For hver rad i datasettet lager PHP en rad i HTML-tabellen
     med kolonner for feltene: Brukernavn, Dato, Innlegg, Likes -->

<table border = 1>
    <thead>
    <tr>
        <th>Brukernavn</th>
        <th>Dato</th>
        <th>Innlegg</th>
        <th>Likes</th>
        <th>Lik innlegget</td>
    </tr>
    </thead>
    <tbody>
    <?php while ($rad = $datasett->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($rad["Brukernavn"]); ?></td>
            <td><?php echo htmlspecialchars($rad["Dato"]); ?></td>
            <td><?php echo htmlspecialchars($rad["Innlegg"]); ?></td>
            <td><?php echo htmlspecialchars($rad["Likes"]); ?></td>
            <td><a style="text-decoration:none" href="mem_add_like.php?InnleggID=<?php echo htmlspecialchars($rad["InnleggID"]); ?>">👍</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>