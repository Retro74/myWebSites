<?php
// Sjekk at forespørselen er POST

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Kun POST er tillatt.");
}

// CSRF-validering

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    http_response_code(403);
    die("Ugyldig forespørsel.");
}

// Klargjør prepared statement

$stmt = $tilkobling->prepare(
    "INSERT INTO tbl_brukere (fornavn, etternavn) VALUES (?,?)"
);

// Bind parametere fra POST-data

$stmt->bind_param("ss",
    $_POST["txt_fornavn"],
    $_POST["txt_etternavn"]
);

// Kjør spørringen

$stmt->execute();
$stmt->close();

// Videresend brukeren etter kjøring

header("Location: takkk.php");
exit();
?>