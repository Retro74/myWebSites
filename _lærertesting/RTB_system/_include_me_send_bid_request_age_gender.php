<?php
// ============================================
// send_bid_request_pinpoint.php
// Sender bid request til de DSP-ene som
// matcher brukerens kjønn og aldersgruppe.
// Trenger en SESSION['kjonn'] = "mann" / "dame"
// og en SESSION['alder'] = 22  |  0-17 = barn | 18-29 = ungdom | over 30 = voksen
// ============================================


//For testing:
//$_SESSION['kjonn'] = "mann";
//$_SESSION['alder'] = 44;
//session_unset();

// --- Hent brukerinfo fra session ---
$kjonn = strtolower(trim($_SESSION['kjonn'] ?? ''));
$alder = (int)($_SESSION['alder'] ?? 0);

// --- Beregn aldersgruppe ---
if ($alder >= 1 && $alder < 18) {
    $aldersgruppe = 'barn';
} elseif ($alder <= 30) {
    $aldersgruppe = 'ungdom';
} elseif ($alder > 30) {
    $aldersgruppe = 'voksen';
} else {
    $aldersgruppe = 'ukjent';
}

// --- Kart: segment → de tre DSP-filene som konkurrerer om dette segmentet ---
// Nøkkelen er "aldersgruppe_kjonn".
// Du fyller inn *2.php og *3.php når de er klare.
$dspKart = [
    'barn_mann'     => [
        'dsp_barn_mann1.php',
        'dsp_barn_mann2.php',
        'dsp_barn_mann3.php',
    ],
    'barn_dame'     => [
        'dsp_barn_dame1.php',
        'dsp_barn_dame2.php',
        'dsp_barn_dame3.php',
    ],
    'ungdom_mann'   => [
        'dsp_ungdom_mann1.php',
        'dsp_ungdom_mann2.php',
        'dsp_ungdom_mann3.php',
    ],
    'ungdom_dame'   => [
        'dsp_ungdom_dame1.php',
        'dsp_ungdom_dame2.php',
        'dsp_ungdom_dame3.php',
    ],
    'voksen_dame'   => [
        'dsp_voksen_dame1.php',
        'dsp_voksen_dame2.php',
        'dsp_voksen_dame3.php',
    ],
    'voksen_mann'   => [
        'dsp_voksen_mann1.php',
        'dsp_voksen_mann2.php',
        'dsp_voksen_mann3.php',
    ],
];

// --- Finn riktig DSP-liste for denne brukeren ---
$segmentNokkel = $aldersgruppe . '_' . $kjonn;
$baseUrl       = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';

if (isset($dspKart[$segmentNokkel])) {
    $dsper = array_map(fn($fil) => $baseUrl . $fil, $dspKart[$segmentNokkel]);
} else {
    // Ukjent segment (ikke innlogget, mangler data) → ingen DSP-er
    $dsper = [];
}

// --- Bygg payload ---
$payload = json_encode([
    'side'         => $_GET['side'] ?? 'forside',
]);

// --- Send bid request til de utvalgte DSP-ene ---
$bud = [];

foreach ($dsper as $url) {
    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'content' => $payload,
            'header'  => "Content-Type: application/json",
            'timeout' => 0.2,
        ]
    ]);

    $svar = @file_get_contents($url, false, $context);

    if ($svar) {
        $dekoda = json_decode($svar, true);
        if (isset($dekoda['bud'], $dekoda['annonse'])) {
            $bud[] = $dekoda;
        }
    }
}

// --- Finn høyeste bud ---
usort($bud, fn($a, $b) => $b['bud'] <=> $a['bud']);
$vinner = $bud[0] ?? null;
?>

<?php if ($vinner): ?>
    <div class="annonse">
        <a href="<?= htmlspecialchars($vinner['annonse']['url']) ?>" target="_blank">
            <img width="160" height="200"
                 src="<?= htmlspecialchars($vinner['annonse']['bilde']) ?>"
                 alt="<?= htmlspecialchars($vinner['annonse']['tittel']) ?>">
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

