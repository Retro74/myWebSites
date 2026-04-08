<?php
// Simulerer en DSP som gir bud rettet mot unge kvinner mellom 19 og 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(150, 250); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'HM - Damer',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Dameklær til en hver anledning ',
        'bilde'  => 'hmkjole.png',
        'url'    => 'https://www2.hm.com/no_no/dame.html'
    ]
]);
