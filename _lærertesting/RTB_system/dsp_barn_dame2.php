<?php
// Simulerer en DSP som gir bud rettet mot jenter under 18 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(110, 190); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Next Kids',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Nye kleskolleksjoner!',
        'bilde'  => 'tops-data.jpg',
        'url'    => 'https://www.next.no/no/girls'
    ]
]);
