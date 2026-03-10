    <?php
    //Databasetilkobling, med databaseplassering, brukernavn, passord og databasenavn 
    $tilkobling = new mysqli("localhost","root","","db_mywebsite");
?>
<?php
// Sjekk at forespørselen er POST



// Sett header til JSON slik at Ajax-kallet forstår svaret

header("Content-Type: application/json; charset=utf-8");

// Hent søkeverdien fra POST

$sokeverdi = $_GET["Postnummer"] ?? "";

// Svar med funnet=false hvis søkeverdien er tom

if (empty($sokeverdi)) {
    echo json_encode(["funnet" => false]);
    exit();
}

// Klargjør prepared statement

$stmt = $tilkobling->prepare(
    "SELECT Poststed FROM tbl_postnummer WHERE Postnummer = ?"
);
if (!$stmt) {
    echo json_encode(["feil" => "Prepare-feil: " . $tilkobling->error]);
    exit();
}

// Bind søkeverdien og kjør spørringen

$stmt->bind_param("s", $sokeverdi);
$stmt->execute();
$datasett = $stmt->get_result();

// Svar med JSON - funnet eller ikke funnet

if ($rad = $datasett->fetch_assoc()) {
    echo json_encode([
        "funnet"       => true,
        "Poststed" => htmlspecialchars($rad["Poststed"])
    ]);
} else {
    echo json_encode(["funnet" => false]);
}

$stmt->close();
?>