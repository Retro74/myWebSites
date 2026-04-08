<?php
// Simulerer en DSP som gir bud basert på brukerdata
header('Content-Type: application/json');

$bud = rand(80, 150); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Sporty AS',
    'bud'  => $bud,
    'annonse'  => [
        'tittel' => 'Sommer-salg sportartikler!',
        'bilde'  => 'sport1.jpg',
        'url'    => 'https://sport1.no'
    ]
]);