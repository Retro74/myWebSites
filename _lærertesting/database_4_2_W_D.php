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

// DELETE: Kjøres når en rad skal slettes

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["command"]) && $_POST["command"] === "delete") {
    
// CSRF-validering

    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        http_response_code(403);
        die("Ugyldig forespørsel.");
    }
        $stmt = $tilkobling->prepare(
        "DELETE FROM tbl_brukere WHERE bruker_id = ?"
    );
    $stmt->bind_param("s", $_POST["bruker_id"]);
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
      <th>Slett</th>
   </tr>
   </thead>
   <tbody>
<?php while ($rad = $datasett->fetch_assoc()) { ?>
   <tr>
      <td><?php echo htmlspecialchars($rad["brukernavn"]); ?></td>
      <td><?php echo htmlspecialchars($rad["passord_hash"]); ?></td>
      <td>
         <form method="POST" onsubmit="return confirm('Er du sikker på at du vil slette denne raden?');">
            <input type="hidden" name="command" value="delete">
            <input type="hidden" name="bruker_id" value="<?php echo htmlspecialchars($rad["bruker_id"]); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="submit" value="Slett">
         </form>
      </td>
   </tr>
<?php } ?>
</tbody>
</table>
</body>
</html>