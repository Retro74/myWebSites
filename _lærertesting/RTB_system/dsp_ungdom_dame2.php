<?php
// Simulerer en DSP som gir bud rettet mot unge kvinner mellom 19 og 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(150, 250); // Mer verdi med brukerdata
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$bildeUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

echo json_encode([
    'budgiver' => 'HM - Damer',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Dameklær til en hver anledning ',
        'bilde'  => $bildeUrl . 'hmkjole.png',
        'url'    => 'https://www2.hm.com/no_no/dame.html'
    ]
]);
