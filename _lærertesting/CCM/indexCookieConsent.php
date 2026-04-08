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

        /* Popup-boks nederst på siden */
        #consent-popup {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #222;
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        #consent-popup p {
            margin: 0;
            flex: 1;
        }

        #consent-popup button {
            padding: 0.6rem 1.4rem;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }

        #btn-ja  { background: #4caf50; color: #fff; }
        #btn-nei { background: #aaa;    color: #fff; }

        /* Advarsel som vises hvis brukeren svarte nei */
        #advarsel {
            display: none;
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            margin-top: 1rem;
        }
    </style>
</head>
<body>

    <h1>Velkommen til min nettside</h1>
    <p>Her er innholdet på siden.</p>

    <div id="advarsel">
        ⚠️ Du har ikke godtatt cookies. Noen funksjoner på siden vil kanskje ikke fungere optimalt.
    </div>

    <!-- Popup -->
    <div id="consent-popup">
        <p>🍪 Vi bruker cookies for at nettsiden skal fungere best mulig. Godtar du dette?</p>
        <button id="btn-ja"  onclick="svarJa()">Ja, jeg godtar</button>
        <button id="btn-nei" onclick="svarNei()">Nei takk</button>
    </div>

    <script>
        // Sjekk om brukeren allerede har svart
        if (getCookie('cookies_godtatt') === 'ja') {
            document.getElementById('consent-popup').style.display = 'none';
        } else if (getCookie('cookies_godtatt') === 'nei') {
            document.getElementById('consent-popup').style.display = 'none';
            document.getElementById('advarsel').style.display = 'block';
        }

        function svarJa() {
            setCookie('cookies_godtatt', 'ja', 30);
            document.getElementById('consent-popup').style.display = 'none';
        }

        function svarNei() {
            setCookie('cookies_godtatt', 'nei', 30);
            document.getElementById('consent-popup').style.display = 'none';
            document.getElementById('advarsel').style.display = 'block';
        }

        // Hjelpefunksjoner for cookies
        function setCookie(navn, verdi, dager) {
            const utloper = new Date();
            utloper.setDate(utloper.getDate() + dager);
            document.cookie = navn + '=' + verdi + '; expires=' + utloper.toUTCString() + '; path=/';
        }

        function getCookie(navn) {
            const deler = document.cookie.split('; ');
            for (const del of deler) {
                const [n, v] = del.split('=');
                if (n === navn) return v;
            }
            return null;
        }
    </script>

</body>
</html>
