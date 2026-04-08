<?php
// Simulerer en DSP som gir bud rettet mot gutter under 18 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(120, 200); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'bonprix.no',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Dresssalg – kun i dag!',
        'bilde'  => $bildeUrl . 'bonnix.png',
        'url'    => 'https://www.bonprix.no/kategori/barn-gutter/'
    ]
]);
