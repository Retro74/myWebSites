<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Databasetilkobling med server, brukernavn, passord og databasenavn

$tilkobling = new mysqli("localhost", "root", "", "db_mywebsite2");

// Sjekk at tilkoblingen var vellykket

if ($tilkobling->connect_error) {
    die("Tilkoblingsfeil: " . $tilkobling->connect_error);
}
?>
<?php
// SQL-spørringen

$sql = "SELECT * FROM tbl_postnummer";

// Kjør spørringen og sett resultatet i datasettet

$datasett = $tilkobling->query($sql);

// Sjekk at spørringen var vellykket

if (!$datasett) {
    die("SQL-feil: " . $tilkobling->error);
}
?>
<?php
// SQL-spørringen

$sql = "SELECT * FROM tbl_postnummer";

// Kjør spørringen og sett resultatet i datasettet

$datasett = $tilkobling->query($sql);

// Sjekk at spørringen var vellykket

if (!$datasett) {
    die("SQL-feil: " . $tilkobling->error);
}
?>


    <form action="" method="POST">
        <?php
// Generer CSRF-token hvis det ikke finnes
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
?>

<!-- HTML/PHP til skjult CSRF-token i form/skjema-->
<input type="hidden" name="csrf_token"
      value="<?php echo $_SESSION['csrf_token']; ?>">

<!--     <input type="text"
       id="sel_postnummer"
       name="sel_postnummer"
       placeholder="Skriv inn Postnummer" onchange="">
-->
       <select name="sel_postnummer"  id="sel_postnummer">
    // For hver rad i datasettet lager PHP ett valg i nedtrekkslisten

    <?php while ($rad = $datasett->fetch_assoc()) { ?>
        <option value="<?php echo htmlspecialchars($rad["Postnummer"]); ?>">
            <?php echo htmlspecialchars($rad["Postnummer"]); ?>
        </option>
    <?php } ?>
</select>
    
    </form>
    <!-- Inputfelt for Ajax-oppslag -->



<!-- Div som viser resultatet -->

<div id="div_Poststed"></div>

<!-- Ajax-kall med jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {

    
// Kjør Ajax-oppslag når brukeren skriver i inputfeltet
    $("#sel_postnummer").on("change", function () {

        var verdi = $(this).val().trim();
        console.log(verdi);

        
// Ikke slå opp hvis feltet er tomt

        if (verdi === "") {
            $("#div_Poststed").html("");
            return;
        }

        
// Send Ajax POST-forespørsel til PHP-siden

        $.ajax({
            url:  "ajax_postnummerOppslag.php",
            type: "POST",
            data: {
                Postnummer: verdi,
                csrf_token: $("input[name='csrf_token']").val()
            },
            dataType: "json",

            success: function (svar) {
                
// Oppdater resultdiven basert på svaret fra PHP

                if (svar.funnet) {
                    $("#div_Poststed").html(
                        "Postnummer finnes. Poststed: " + svar.Poststed
                    );
                } else {
                    $("#div_Poststed").html("Postnummer ble ikke funnet.");
                }
            },

            error: function () {
                $("#div_Poststed").html("Feil ved oppslag. Prøv igjen.");
            }
        });
    });
});
</script>
</body>
</html>