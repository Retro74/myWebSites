<?php
session_start();

// Opprett CSRF-token hvis den ikke finnes
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include("databaseconnection.php");

// SQL-spørringen

$sql = "SELECT * FROM tbl_postnummer";

// Kjør spørringen og sett resultatet i datasettet

$datasett = $tilkobling->query($sql);

// Sjekk at spørringen var vellykket

if (!$datasett) {
    die("SQL-feil: " . $tilkobling->error);
}
?>
<link rel="stylesheet" href="modal.css">
<body>

<h2>Modal Signup Form</h2>

<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Sign Up</button>

<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
  <form method="post"class="modal-content animate" action="pub_registrerMottak.php">
    <div class="container">
      <h1>Registreringsskjema</h1>
      <p>Fyll ut informasjonen nedenfor</p>
      <hr>
        <label for="inp_brukernavn"><b>Brukernavn</b></label>
        <input type="text" placeholder="Velg brukernavn" name="inp_brukernavn" required>

        <label for="inp_fornavn"><b>Fornavn</b></label>
        <input type="text" placeholder="Fornavn" name="inp_fornavn" required>

        <label for="inp_etternavn"><b>Etternavn</b></label>
        <input type="text" placeholder="Etternavn" name="inp_etternavn" required>

        <label for="inp_mail"><b>E-post</b></label>
        <input type="text" placeholder="E-post" name="inp_mail" required>

        <label for="inp_passord"><b>Passord</b></label>
        <input type="password" placeholder="Velg passord" id="inp_passord" name="inp_passord" required>

        <label for="inp_gjenta_passord"><b>Gjenta passord</b></label>
        <input type="password" placeholder="Gjenta passord" oninput="check(this)" id="inp_gjenta_passord" name="inp_gjenta_passord" required>

        <label for="inp_adresse"><b>Gateaddresse</b></label>
        <input type="text" placeholder="Gateadresse" name="inp_adresse" required>

        <label for="inp_husnummer"><b></b>Husnummer</label>
        <input type="text" placeholder="Husnummer" name="inp_husnummer" required>
        
        <label for="set_postnummer"><b>Postnummer</b></label>
   
   <br>
       <select id="set_postnummer" name="set_postnummer" id="set_postnummer">   
        

 <?php while ($rad = $datasett->fetch_assoc()) { ?>
        <option value="<?php echo htmlspecialchars($rad["Postnummer"]); ?>">
            <?php echo htmlspecialchars($rad["Postnummer"]); ?>
        </option>
    <?php } ?>
</select>
<div id="div_poststed"></div>
   
        <!-- HTML/PHP til skjult CSRF-token i form/skjema -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
     
     <!-- Husk å legge inn inputfelt for Ajax-oppslag med:
       id="set_postnummer"
       name="set_postnummer"
       -->
      

<!-- Og et element som kan vise resultatet med 
id="div_poststed"-->



<!-- Ajax-kall med jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 
<script>
$(document).ready(function () {

    
// Kjør Ajax-oppslag når brukeren skriver i inputfeltet

    $("#set_postnummer").on("change", function () {
        var verdi = $(this).val().trim();
        console.log(verdi);
        
        
// Ikke slå opp hvis feltet er tomt

        if (verdi === "") {
            $("#div_poststed").html("");
            return;
        }

    
// Send Ajax POST-forespørsel til PHP-siden

        $.ajax({
            url:  "AJAX_poststed.php",
            type: "POST",
            data: {
                Postnummer: verdi,
                csrf_token: $("input[name='csrf_token']").val()
            },
            dataType: "json",

            success: function (svar) {
                
// Oppdater resultdiven basert på svaret fra PHP

                if (svar.funnet) {
                    $("#div_poststed").html(
                        "Postnummer finnes. Poststed: " + svar.Poststed
                    );
                } else {
                    $("#div_poststed").html("Postnummer ble ikke funnet.");
                }
            },

            error: function () {
                $("#div_poststed").html("Feil ved oppslag. Prøv igjen.");
            }
        });
    });
});

</script>
   
     
     
        <!-- <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>
         <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
-->


   
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');
document.getElementById('id01').style.display='block'   
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
function check(input) {
    if (input.value != document.getElementById('inp_passord').value) {
        input.setCustomValidity('Passordene må være like!');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
    }
    
}


</script>

</body>
</html>
