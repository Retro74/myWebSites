<?php
// ============================================
// send_bid_request_pinpoint.php
// Sender bid request til de DSP-ene
// ============================================


$payload = json_encode([
    'side'       => $_GET['side'] ?? 'forside',
]);
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dirNow  = str_replace('\\', '/', __DIR__);
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($docRoot, '', $dirNow) . '/';

$dsper = [
    $baseUrl . 'dsp1.php',
    $baseUrl . 'dsp2.php',
    $baseUrl . 'dsp3.php',
];

$bud = [];

foreach ($dsper as $url) {
    $svar = file_get_contents($url, false, stream_context_create([
        'http' => [
            'method'  => 'GET',
            'header'  => "Content-Type: application/json"
        ]
    ]));

    if ($svar) {
        $bud[] = json_decode($svar, true);
    }
}

// Finn høyeste bud
usort($bud, fn($a, $b) => $b['bud'] <=> $a['bud']);
$vinner = $bud[0] ?? null;
?>
<?php if ($vinner): ?>
    <div class="annonse">
        <a href="<?= htmlspecialchars($vinner['annonse']['url']) ?>" target="_blank">
            <img width=200 height=260 src="<?= htmlspecialchars($vinner['annonse']['bilde']) ?>" alt="<?= htmlspecialchars($vinner['annonse']['tittel']) ?>">
            <h3><?= htmlspecialchars($vinner['annonse']['tittel']) ?></h3>
        </a>
                <p class="annonse-meta">
            Annonsør: <?= htmlspecialchars($vinner['budgiver']) ?> |
            Bud: <?= $vinner['bud'] ?> øre
        </p>

    </div>
<?php else: ?>
    <p>Ingen annonser tilgjengelig.</p>
<?php endif; ?>
