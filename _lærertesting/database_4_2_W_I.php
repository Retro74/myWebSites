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

// INSERT: Kjøres når skjema for ny rad sendes inn

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["command"]) && $_POST["command"] === "insert") {
    
// CSRF-validering

    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        http_response_code(403);
        die("Ugyldig forespørsel.");
    }
        $stmt = $tilkobling->prepare(
        "INSERT INTO tbl_brukere (brukernavn, passord_hash) VALUES (?, ?)"
    );
    $stmt->bind_param("ss",
        $_POST["brukernavn"],
        $_POST["passord_hash"]
    );
    $stmt->execute();
    $stmt->close();
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

<!-- Rad for å legge til nye data -->

   <tr>
   <form method="POST">
   <input type="hidden" name="command" value="insert">
   <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      <td>
         <input type="text" name="brukernavn" placeholder="brukernavn">
      </td>
      <td>
         <input type="text" name="passord_hash" placeholder="passord_hash">
      </td>
      <td><input type="submit" value="Legg til"></td>
   </form>
   </tr>
</tbody>
</table>
</body>
</html>