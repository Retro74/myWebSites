<?php
// Simulerer en DSP som gir bud rettet mot unge menn mellom 19 og 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(140, 220); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'XXL',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Sporstytyr',
        'bilde'  => $bildeUrl . 'xxl.png',
        'url'    => 'https://www.xxl.no/kampanje?cid=pakkepriser'
    ]
]);
