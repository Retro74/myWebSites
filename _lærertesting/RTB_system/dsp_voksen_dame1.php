<?php
// Simulerer en DSP som gir bud rettet mot kvinner over 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(180, 300); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'Garnius AS',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Stikk deg glad',
        'bilde'  => $bildeUrl . 'garnius.png',
        'url'    => 'https://www.garnius.no/strikkepakker'
    ]
]);
