<?php
// Simulerer en DSP som gir bud rettet mot jenter under 18 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(110, 190); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'Gina Tricot',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Nye plagg i dag!',
        'bilde'  => $bildeUrl . 'hoodie.jpg',
        'url'    => 'https://www.ginatricot.com/no/young-gina'
    ]
]);
