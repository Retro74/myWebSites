<!DOCTYPE html>
<html lang="no">
<head>
<meta charset="UTF-8">
<title>Brukere</title>
</head>
<body>

<?php
// ---------------- DATABASE ----------------
$tilkobling = new mysqli("localhost","root","","db_mywebsite");

if ($tilkobling->connect_error) {
    die("Tilkoblingsfeil: " . $tilkobling->connect_error);
}

$tilkobling->set_charset("utf8mb4");

?>
<?php
// Opprett en CSRF-token hvis den ikke finnes
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// SELECT: Henter alle rader fra tabellen

$sql_select = "SELECT brukernavn, passord_hash, bruker_id FROM tbl_brukere";
$datasett = $tilkobling->query($sql_select);

// Hent hvilken rad som ev. er i redigeringsmodus (fra GET)

$edit_id = isset($_GET["edit_id"]) ? (int)$_GET["edit_id"] : null;

?>

<!-- HTML-tabell med data fra databasen -->

<table border="1">
   <thead>
   <tr>
      <th>Brukernavn</th>
      <th>Passord_hash</th>
   </tr>
   </thead>
   <tbody>
<?php while ($rad = $datasett->fetch_assoc()) { ?>
   <tr>
      <td><?php echo htmlspecialchars($rad["brukernavn"]); ?></td>
      <td><?php echo htmlspecialchars($rad["passord_hash"]); ?></td>
   </tr>
<?php } ?>
</tbody>
</table>
</body>
</html>