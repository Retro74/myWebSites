
<?php
// include("mem_checker.php");

include_once("dbcon.php");
// Klargjør prepared statement

$stmt = $tilkobling->prepare(
    "UPDATE tbl_gjestebok
SET Likes = Likes +1
WHERE InnleggID = ?"
);

// Bind felter fra POST og primærnøkkel fra $_GET

$stmt->bind_param("s",
    $_GET["InnleggID"]
);

// Kjør spørringen

$stmt->execute();
$stmt->close();

// Videresend brukeren etter kjøring

header("Location: mem_visgjestebok.php");
exit();
?>