<?php
// Simulerer en DSP som gir bud rettet mot kvinner over 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(180, 300); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Garnius AS',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Stikk deg glad',
        'bilde'  => 'garnius.png',
        'url'    => 'https://www.garnius.no/strikkepakker'
    ]
]);
