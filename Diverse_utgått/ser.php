<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
// Databasetilkobling med server, brukernavn, passord og databasenavn

$tilkobling = new mysqli("localhost", "root", "", "db_mywebsite2");
?>

<?php
// Oppretter en CSRF-token for å verifisere at det er siden selv som sender

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// INSERT: Kjøres når skjema for ny rad sendes inn

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["command"]) && $_POST["command"] === "insert") {
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        http_response_code(403);
        die("Ugyldig forespørsel.");
    }
        $stmt = $tilkobling->prepare(
        "INSERT INTO tbl_gjestebok (Brukernavn, Innlegg) VALUES (?, ?)"
    );
    $stmt->bind_param("ss",
        $_POST["Brukernavn"],
        $_POST["Innlegg"]
    );
    $stmt->execute();
    $stmt->close();
}

// SELECT: Henter alle rader fra tabellen

$sql_select = "SELECT Brukernavn, Innlegg, InnleggID FROM tbl_gjestebok";
$datasett = $tilkobling->query($sql_select);

// Hent hvilken rad som ev. er i redigeringsmodus (fra GET)

$edit_id = isset($_GET["edit_id"]) ? $_GET["edit_id"] : null;

?>

<!-- HTML-tabell med data fra databasen -->

<table border="1">
   <thead>
   <tr>
      <th>Brukernavn</th>
      <th>Innlegg</th>
   </tr>
   </thead>
   <tbody>
<?php while ($rad = $datasett->fetch_assoc()) { ?>
   <tr>
      <td><?php echo htmlspecialchars($rad["Brukernavn"]); ?></td>
      <td><?php echo htmlspecialchars($rad["Innlegg"]); ?></td>
   </tr>
<?php } ?>

<!-- Rad for å legge til nye data -->

   <tr>
   <form method="POST">
   <input type="hidden" name="command" value="insert">
   <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      <td>
         <input type="text" name="Brukernavn" placeholder="Brukernavn">
      </td>
      <td>
         <input type="text" name="Innlegg" placeholder="Innlegg">
      </td>
      <td><input type="submit" value="Legg til"></td>
   </form>
   </tr>
</tbody>
</table>
</body>
</html>