<?php
// Simulerer en DSP som gir bud rettet mot gutter under 18 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(120, 200); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Teen Stickers - Norge',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Nye FIFA-kort – kun i dag!',
        'bilde'  => 'fifakort.jpg',
        'url'    => 'https://www.tenstickers-norge.com/'
    ]
]);
