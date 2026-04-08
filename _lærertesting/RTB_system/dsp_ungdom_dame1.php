<?php
// Simulerer en DSP som gir bud rettet mot unge kvinner mellom 19 og 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(150, 250); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Nelly Annonser',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => '30% på sommerklær – bare i dag!',
        'bilde'  => 'nelly.png',
        'url'    => 'https://nelly.com/'
    ]
]);
