<?php
// Simulerer en DSP som gir bud rettet mot menn over 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(160, 270); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Husfliden AS',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Herrebunad til 17. mai?',
        'bilde'  => 'herrebunad.jpg',
        'url'    => 'https://www.norskflid.no/bunad/herre/'
    ]
]);
