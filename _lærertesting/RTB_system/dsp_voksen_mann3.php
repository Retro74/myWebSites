<?php
// Simulerer en DSP som gir bud rettet mot menn over 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(160, 270); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'Jula AS',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Herrejakke på tilbud!',
        'bilde'  => $bildeUrl . 'jula.png',
        'url'    => 'https://www.jula.no/catalog/klar-og-verneutstyr/herreklar/fritidsklar/friluftsjakker/jakke-herre-028708/'
    ]
]);
