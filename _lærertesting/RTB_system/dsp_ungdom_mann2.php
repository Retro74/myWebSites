<?php
// Simulerer en DSP som gir bud rettet mot unge menn mellom 19 og 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(140, 220); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'Jack & Jones AS',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Dress til sommeren?',
        'bilde'  => $bildeUrl . 'jAndJ.png',
        'url'    => 'https://www.jackjones.com/'
    ]
]);
