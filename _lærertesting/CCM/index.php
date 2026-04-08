<?php
// ============================================
// index.php
// Cookie consent med tilpasset reklame-valg
// Lagrer i cookie og database
// ============================================

session_start();

// --- Databasetilkobling ---
$host = 'localhost';
$db   = 'skole_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Databasefeil: ' . $e->getMessage());
}

// --- Hent bruker-ID fra session (hvis innlogget) ---
$userId = $_SESSION['user_id'] ?? null;

// --- Hent eksisterende samtykke fra cookie ---
$samtykke = json_decode($_COOKIE['cookie_consent'] ?? '{}', true);
$cookiesGodtatt    = ($samtykke['godtatt']           ?? '') === 'ja';
$harSvart          = isset($samtykke['godtatt']);
$tilpassetReklame  = (bool)($samtykke['tilpasset_reklame'] ?? false);

// --- Hent samtykke fra database hvis innlogget og ingen cookie ---
if ($userId && !$harSvart) {
    $stmt = $pdo->prepare("SELECT * FROM bruker_samtykke WHERE user_id = ? ORDER BY oppdatert DESC LIMIT 1");
    $stmt->execute([$userId]);
    $rad = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rad) {
        // Gjenopprett cookie fra database
        $harSvart         = true;
        $cookiesGodtatt   = true;
        $tilpassetReklame = (bool)$rad['tilpasset_reklame'];

        setcookie('cookie_consent', json_encode([
            'godtatt'          => 'ja',
            'tilpasset_reklame' => $tilpassetReklame
        ]), time() + (30 * 24 * 3600), '/', '', false, true);
    }
}
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Min nettside</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
        }

        /* Advarsel for brukere som har svart nei */
        #advarsel {
            display: none;
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        /* Popup nederst på siden */
        #consent-popup {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #222;
            color: #fff;
            padding: 1.5rem 2rem;
            display: none; /* Vises av JS hvis brukeren ikke har svart */
        }

        #consent-popup p {
            margin: 0 0 1rem 0;
        }

        .knapp-rad {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            align-items: center;
        }

        #consent-popup button {
            padding: 0.6rem 1.4rem;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }

        #btn-ja       { background: #4caf50; color: #fff; }
        #btn-nei      { background: #aaa;    color: #fff; }
        #btn-tilpass  { background: transparent; color: #fff;
                        border: 2px solid #fff !important; }

        /* Tilpass-panel (skjult som standard) */
        #tilpass-panel {
            display: none;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #555;
        }

        #tilpass-panel label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
        }

        #tilpass-panel input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        #btn-lagre { background: #2196f3; color: #fff; margin-top: 0.5rem; }
    </style>
</head>
<body>

    <h1>Velkommen til min nettside</h1>
    <p>Her er innholdet på siden.</p>

    <!-- Advarsel hvis brukeren har svart nei -->
    <div id="advarsel">
        ⚠️ Du har ikke godtatt cookies. Noen funksjoner på siden vil kanskje ikke fungere som de skal.
    </div>

    <!-- Annonseplass: vises kun hvis cookies er godtatt -->
    <?php if ($cookiesGodtatt): ?>
        <div class="annonse">
            <?php include 'send_bid_request_pinpoint.php'; ?>
        </div>
    <?php endif; ?>

    <!-- Cookie consent popup -->
    <div id="consent-popup">
        <p>🍪 Vi bruker cookies for at nettsiden skal fungere best mulig. Godtar du dette?</p>

        <div class="knapp-rad">
            <button id="btn-ja"     onclick="svarJa()">Ja, jeg godtar</button>
            <button id="btn-nei"    onclick="svarNei()">Nei takk</button>
            <button id="btn-tilpass" onclick="visTilpass()">Tilpass valg ▾</button>
        </div>

        <!-- Tilpass-panel -->
        <div id="tilpass-panel">
            <label>
                <input type="checkbox" id="cb-nodvendig" checked disabled>
                <span>
                    <strong>Nødvendige cookies</strong> – kreves for at siden skal fungere (kan ikke slås av)
                </span>
            </label>
            <label>
                <input type="checkbox" id="cb-reklame">
                <span>
                    <strong>Tilpasset reklame og innhold</strong> – lar oss vise annonser som passer for deg
                </span>
            </label>
            <br>
            <button id="btn-lagre" onclick="lagreValg()">Lagre mine valg</button>
        </div>
    </div>

    <script>
        // --- Hjelpefunksjoner for cookies ---
        function setCookie(navn, verdi, dager) {
            const utloper = new Date();
            utloper.setDate(utloper.getDate() + dager);
            document.cookie = navn + '=' + encodeURIComponent(verdi)
                + '; expires=' + utloper.toUTCString() + '; path=/';
        }

        function getCookie(navn) {
            const deler = document.cookie.split('; ');
            for (const del of deler) {
                const [n, v] = del.split('=');
                if (n === navn) return decodeURIComponent(v);
            }
            return null;
        }

        // --- Vis popup hvis brukeren ikke har svart ennå ---
        const eksisterende = getCookie('cookie_consent');
        if (!eksisterende) {
            document.getElementById('consent-popup').style.display = 'block';
        } else {
            // Vis advarsel hvis brukeren tidligere svarte nei
            const data = JSON.parse(eksisterende);
            if (data.godtatt === 'nei') {
                document.getElementById('advarsel').style.display = 'block';
            }
        }

        // --- Vis/skjul tilpass-panel ---
        function visTilpass() {
            const panel = document.getElementById('tilpass-panel');
            panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
        }

        // --- Godta alle ---
        function svarJa() {
            sendSamtykke('ja', true);
        }

        // --- Avvis alle ---
        function svarNei() {
            sendSamtykke('nei', false);
        }

        // --- Lagre egne valg fra tilpass-panel ---
        function lagreValg() {
            const tilpassetReklame = document.getElementById('cb-reklame').checked;
            sendSamtykke('ja', tilpassetReklame);
        }

        // --- Send samtykke til serveren og sett cookie ---
        function sendSamtykke(godtatt, tilpassetReklame) {
            fetch('lagre_samtykke.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    godtatt:           godtatt,
                    tilpasset_reklame: tilpassetReklame
                })
            })
            .then(svar => svar.json())
            .then(data => {
                if (data.status === 'ok') {
                    document.getElementById('consent-popup').style.display = 'none';

                    if (godtatt === 'nei') {
                        document.getElementById('advarsel').style.display = 'block';
                    } else {
                        // Last siden på nytt slik at annonsen vises
                        location.reload();
                    }
                }
            });
        }
    </script>

</body>
</html>