<?php
// Simulerer en DSP som gir bud basert på brukerdata
header('Content-Type: application/json');

$bud = rand(80, 150); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Power AS',
    'bud'  => $bud,
    'annonse'  => [
        'tittel' => 'Ny PC!',
        'bilde'  => 'pc.png',
        'url'    => 'https://power.no'
    ]
]);