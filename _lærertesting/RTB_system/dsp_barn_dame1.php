<?php
// Simulerer en DSP som gir bud rettet mot jenter under 18 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(110, 190); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'PikeShop Reklame',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Nye samlekort og tilbehør – kun i dag!',
        'bilde'  => 'pikeshop_tilbud.png',
        'url'    => 'https://eksempel-pikeshop.no/tilbud'
    ]
]);
