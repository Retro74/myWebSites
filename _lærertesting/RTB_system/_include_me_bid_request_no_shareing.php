<?php
// ============================================
// send_bid_request_pinpoint.php
// Sender bid request til de DSP-ene
// ============================================


$payload = json_encode([
    'side'       => $_GET['side'] ?? 'forside',
]);

$dsper = [
    'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/dsp1.php',
    'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/dsp2.php',
    'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/dsp3.php',
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
