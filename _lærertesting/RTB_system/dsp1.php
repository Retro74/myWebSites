<?php
// Simulerer en DSP som gir bud basert på brukerdata
header('Content-Type: application/json');

$bud = rand(80, 150); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'Sporty AS',
    'bud'  => $bud,
    'annonse'  => [
        'tittel' => 'Sommer-salg sportartikler!',
        'bilde'  => $bildeUrl . 'sport1.jpg',
        'url'    => 'https://sport1.no'
    ]
]);