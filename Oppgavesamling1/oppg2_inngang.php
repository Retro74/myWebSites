<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inngang</title>
    <style>
        select {
            background-color: #e0f0ff; /* lys blå bakgrunn */
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #888;
            font-size: 16px;
            }
        body {
                background-color: #f5f5f5; /* lys grå bakgrunn */
                font-family: Arial, sans-serif;
            }
        p.error {
            background-color: #ffe5e5;   /* lys rød bakgrunn */
            color: #b30000;              /* mørk rød tekst */
            border: 1px solid #ff4d4d;   /* tydelig rød kant */
            padding: 10px 14px;
            border-radius: 4px;
            font-weight: 600;
            max-width: 400px;            /* valgfritt: gjør den kompakt */
        }
    </style>
</head>
<body>
    <h1>Sett inn tilgangskode</h1>
    <img src="images/secure.png" width=100>
    <form method="post" action="oppg2_sjekk.php">
    <select id="bokstav1" name="bokstav1">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        <option value="E">E</option>
        <option value="F">F</option>
    </select>
    <select id="bokstav2" name="bokstav2">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        <option value="E">E</option>
        <option value="F">F</option>
    </select>
    <select id="bokstav3" name="bokstav3">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        <option value="E">E</option>
        <option value="F">F</option>
    </select>
    <button type="submit">Tilgang</button>
    </form>
    
        <?php  if(isset($_SESSION["feilmelding"])) {
            echo('<p class="error">');
            echo($_SESSION["feilmelding"]);
            echo('</p>');
        } 
        ?>
 </body>
</html>