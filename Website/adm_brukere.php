<?php include_once("dbcon.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Brukere</h2>
    <?php
// SQL-spørringen

$sql = "SELECT * FROM tbl_brukere";

// Kjør spørringen og sett resultatet i datasettet

$datasett = $tilkobling->query($sql);

// Sjekk at spørringen var vellykket

if (!$datasett) {
    die("SQL-feil: " . $tilkobling->error);
}
?>
<!-- For hver rad i datasettet lager PHP en rad i HTML-tabellen
     med kolonner for feltene: Brukernavn, Fornavn, Etternavn, ProfileImage -->

<table>
    <thead>
    <tr>
        <th>Brukernavn</th>
        <th>Fornavn</th>
        <th>Etternavn</th>
        <th>ProfileImage</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($rad = $datasett->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($rad["Brukernavn"]); ?></td>
            <td><?php echo htmlspecialchars($rad["Fornavn"]); ?></td>
            <td><?php echo htmlspecialchars($rad["Etternavn"]); ?></td>
            <td><a href="adm_editProfileImage.php?Brukernavn=<?php echo htmlspecialchars($rad["Brukernavn"]); ?>"><img width=100 src="<?php echo htmlspecialchars($rad["ProfileImage"]); ?>"></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>