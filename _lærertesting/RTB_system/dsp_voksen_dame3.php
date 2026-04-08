<?php
// Simulerer en DSP som gir bud rettet mot kvinner over 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(180, 300); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'Cubus AS',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => '100% lin - 25% rabatt',
        'bilde'  => $bildeUrl . 'cubus_dame.png',
        'url'    => 'https://cubus.com/no/dame'
    ]
]);
