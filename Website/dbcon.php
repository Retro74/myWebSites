<?php
// Databasetilkobling med server, brukernavn, passord og databasenavn

$tilkobling = new mysqli("localhost", "root", "", "db_mywebsite2");

// Sjekk at tilkoblingen var vellykket

if ($tilkobling->connect_error) {
    die("Tilkoblingsfeil: " . $tilkobling->connect_error);
}
?>