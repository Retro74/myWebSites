<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Consent – IT1 Eksempel</title>
    <style>
        /* ===== GENERELL SIDE ===== */
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4f8;
            color: #1a202c;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .side-innhold {
            text-align: center;
            padding: 2rem;
            opacity: 0.4; /* Dimmet mens popup vises */
            transition: opacity 0.4s ease;
        }

        .side-innhold.aktiv { opacity: 1; }

        /* ===== OVERLAY (mørk bakgrunn) ===== */
        #overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 999;
            display: flex;
            align-items: flex-end;       /* Popup kommer fra bunnen */
            justify-content: center;
            padding: 1rem;
        }

        #overlay.skjult { display: none; }

        /* ===== POPUP-BOKS ===== */
        .consent-boks {
            background: #ffffff;
            border-radius: 16px 16px 0 0;
            padding: 2rem;
            max-width: 640px;
            width: 100%;
            box-shadow: 0 -4px 40px rgba(0,0,0,0.2);
            animation: glideOpp 0.4s ease;
        }

        @keyframes glideOpp {
            from { transform: translateY(100%); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }

        .consent-boks h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .consent-boks p {
            font-size: 0.9rem;
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        /* ===== KNAPPER (standardvisning) ===== */
        .knapp-rad {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            padding: 0.7rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: filter 0.2s;
        }

        .btn:hover { filter: brightness(0.92); }

        .btn-godta   { background: #2b6cb0; color: white; }
        .btn-avvis   { background: #e2e8f0; color: #2d3748; }
        .btn-tilpass { background: transparent; color: #2b6cb0;
                       border: 2px solid #2b6cb0; flex: unset; }

        /* ===== TILPASS-PANEL (skjult som standard) ===== */
        #tilpass-panel {
            display: none;
            margin-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            padding-top: 1.5rem;
        }

        #tilpass-panel.vis { display: block; }

        /* ===== TOGGLE-RADER ===== */
        .toggle-rad {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f7fafc;
        }

        .toggle-tekst strong { font-size: 0.9rem; }
        .toggle-tekst p { font-size: 0.8rem; color: #718096; margin-top: 0.2rem; }

        /* Toggle-switch */
        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
        }

        .toggle-switch input { opacity: 0; width: 0; height: 0; }

        .slider {
            position: absolute;
            inset: 0;
            background: #cbd5e0;
            border-radius: 24px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .slider::before {
            content: '';
            position: absolute;
            width: 18px; height: 18px;
            left: 3px; top: 3px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        input:checked + .slider              { background: #2b6cb0; }
        input:checked + .slider::before      { transform: translateX(20px); }
        input:disabled + .slider             { opacity: 0.6; cursor: not-allowed; }

        /* ===== STATUS-MELDING ===== */
        #status {
            display: none;
            margin-top: 1rem;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            background: #c6f6d5;
            color: #276749;
        }
    </style>
</head>
<body>

<!-- Sideinnholdet i bakgrunnen -->
<div class="side-innhold" id="side-innhold">
    <h1>🏫 Min skole-nettside</h1>
    <p>Her er innholdet på siden.</p>
</div>

<!-- ===== COOKIE POPUP ===== -->
<div id="overlay">
    <div class="consent-boks" role="dialog" aria-labelledby="consent-tittel">

        <h2 id="consent-tittel">🍪 Vi bruker informasjonskapsler</h2>
        <p>
            Vi bruker cookies for å gjøre nettsiden bedre.
            Noen er nødvendige for at siden skal fungere,
            mens andre hjelper oss forstå hvordan den brukes.
        </p>

        <!-- Tre hovedknapper -->
        <div class="knapp-rad">
            <button class="btn btn-godta"   onclick="godtaAlle()">Godta alle</button>
            <button class="btn btn-avvis"   onclick="avvisAlle()">Kun nødvendige</button>
            <button class="btn btn-tilpass" onclick="visTilpass()">Tilpass valg ▾</button>
        </div>

        <!-- Tilpass-panel (skjult som standard) -->
        <div id="tilpass-panel">

            <!-- Nødvendige: alltid på, deaktivert -->
            <div class="toggle-rad">
                <div class="toggle-tekst">
                    <strong>🔒 Nødvendige</strong>
                    <p>Påkrevd for at siden skal fungere. Kan ikke slås av.</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked disabled>
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Statistikk -->
            <div class="toggle-rad">
                <div class="toggle-tekst">
                    <strong>📊 Statistikk</strong>
                    <p>Hjelper oss forstå hvordan siden brukes. Dataene er anonyme.</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="toggle-statistikk">
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Markedsføring -->
            <div class="toggle-rad">
                <div class="toggle-tekst">
                    <strong>📣 Markedsføring</strong>
                    <p>Brukes til å vise relevante annonser på andre nettsteder.</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="toggle-marketing">
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Preferanser -->
            <div class="toggle-rad">
                <div class="toggle-tekst">
                    <strong>⚙️ Preferanser</strong>
                    <p>Husker innstillingene dine, som språk og visningsvalg.</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="toggle-preferences">
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Lagre-knapp -->
            <div class="knapp-rad" style="margin-top: 1.25rem;">
                <button class="btn btn-godta" onclick="lagreEgneValg()">
                    Lagre mine valg
                </button>
            </div>
        </div>

        <div id="status"></div>
    </div>
</div>

<script>
// ============================================
// consent.js – Cookie Consent logikk
// ============================================

// Sjekk om samtykke allerede er gitt (cookie finnes)
document.addEventListener('DOMContentLoaded', () => {
    if (getCookie('cookie_consent')) {
        skjulPopup(); // Allerede svart → ikke vis popup
    }
});

// --- Hjelp: les en cookie ---
function getCookie(navn) {
    const verdi = `; ${document.cookie}`;
    const deler = verdi.split(`; ${navn}=`);
    if (deler.length === 2) return deler.pop().split(';').shift();
    return null;
}

// --- Vis tilpass-panel ---
function visTilpass() {
    document.getElementById('tilpass-panel').classList.toggle('vis');
}

// --- Godta alle ---
function godtaAlle() {
    sendSamtykke({
        method:      'accept_all',
        statistics:  true,
        marketing:   true,
        preferences: true
    });
}

// --- Kun nødvendige ---
function avvisAlle() {
    sendSamtykke({
        method:      'deny_all',
        statistics:  false,
        marketing:   false,
        preferences: false
    });
}

// --- Lagre egne valg ---
function lagreEgneValg() {
    sendSamtykke({
        method:      'custom',
        statistics:  document.getElementById('toggle-statistikk').checked,
        marketing:   document.getElementById('toggle-marketing').checked,
        preferences: document.getElementById('toggle-preferences').checked
    });
}

// --- Send til PHP og lagre ---
async function sendSamtykke(valg) {
    try {
        const svar = await fetch('save_consent.php', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(valg)
        });

        const data = await svar.json();

        if (data.status === 'ok') {
            visStatus('✅ Valget ditt er lagret. Takk!');
            setTimeout(skjulPopup, 1200);
        } else {
            visStatus('⚠️ Noe gikk galt. Prøv igjen.');
        }
    } catch (feil) {
        console.error('Feil ved lagring:', feil);
        visStatus('⚠️ Kunne ikke koble til serveren.');
    }
}

function visStatus(melding) {
    const el = document.getElementById('status');
    el.textContent = melding;
    el.style.display = 'block';
}

function skjulPopup() {
    document.getElementById('overlay').classList.add('skjult');
    document.getElementById('side-innhold').classList.add('aktiv');
}
</script>

</body>
</html>