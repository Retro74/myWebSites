<?php
// Simulerer en DSP som gir bud basert på brukerdata
header('Content-Type: application/json');
$bud = rand(80, 150); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Dressmann AS',
    'bud'  => $bud,
    'annonse'  => [
        'tittel' => 'Sommer-salg konfirmasjonsderesser!',
        'bilde'  => 'dressmann.jpg',
        'url'    => 'https://dressmann.no'
    ]
]);