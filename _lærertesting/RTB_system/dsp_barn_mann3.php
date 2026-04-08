<?php
// Simulerer en DSP som gir bud rettet mot gutter under 18 år
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$bud = rand(120, 200); // Mer verdi med brukerdata

echo json_encode([
    'budgiver' => 'Exktra leker',
    'bud'      => $bud,
    'annonse'  => [
        'tittel' => 'Leker til en hver anledning! Legotilbud',
        'bilde'  => 'lego_extra_leker.jpg',
        'url'    => 'https://www.extra-leker.no/'
    ]
]);
