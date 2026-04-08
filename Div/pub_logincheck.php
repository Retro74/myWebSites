<head><title>LoginCheck</title></head>
<?php     include("databaseconnection.php"); 

// Sjekk at forespørselen er POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Kun POST er tillatt."); }

// CSRF-validering
if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    http_response_code(403);
    die("Ugyldig forespørsel."); }

// Prepared statement - hent rad basert på ikke-hashede felter
$stmt = $tilkobling->prepare(
    "SELECT * FROM tbl_brukere WHERE brukernavn = ?" );

if (!$stmt) {
    die("Prepare-feil: " . $tilkobling->error); }
// Bind parametere fra POST-data
$stmt->bind_param("s", $_POST["inp_brukernavn"] );

// Kjør spørringen og hent datasett
$stmt->execute();
$datasett = $stmt->get_result();
if (!$datasett) {
    die("SQL-feil: " . $tilkobling->error); }

    // Passordet verifiseres etterpå med password_verify()
$rad = $datasett->fetch_assoc();
if ($rad && password_verify($_POST["inp_passord"], $rad["Passord_hash"])) {
    // Gyldig - passord stemmer med lagret hash
    echo("Gyldig brukernavn og passord");
} else {
    // Ugyldig - bruker ikke funnet eller feil passord
    echo("Ugyldig brukernavn eller passord");}
?>






