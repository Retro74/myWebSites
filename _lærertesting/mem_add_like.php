<?php
//Legg til mem_checker.php

// Klargjør prepared statement

$stmt = $tilkobling->prepare(
    "UPDATE tbl_gjestebok
SET likes = likes + 1
WHERE innleggID = ?"
);

// Bind felter fra POST og primærnøkkel fra $_GET

$stmt->bind_param("s",
    $_$_GET["InnleggID"]
);

// Kjør spørringen

$stmt->execute();
$stmt->close();

// Videresend brukeren etter kjøring

header("Location: mem_visgjestebok.php");
exit();
?>