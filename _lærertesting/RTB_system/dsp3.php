<?php
// Simulerer en DSP som gir bud basert på brukerdata
header('Content-Type: application/json');
$bud = rand(80, 150); // Mer verdi med brukerdata

$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'Dressmann AS',
    'bud'  => $bud,
    'annonse'  => [
        'tittel' => 'Sommer-salg konfirmasjonsderesser!',
        'bilde'  => $bildeUrl . 'dressmann.jpg',
        'url'    => 'https://dressmann.no'
    ]
]);