<?php
// Simulerer en DSP som gir bud rettet mot menn over 30 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(160, 270); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Jula AS',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Herrejakke på tilbud!',
        'bilde'  => 'jula.png',
        'url'    => 'https://www.jula.no/catalog/klar-og-verneutstyr/herreklar/fritidsklar/friluftsjakker/jakke-herre-028708/'
    ]
]);
