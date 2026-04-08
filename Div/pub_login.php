


<link rel="stylesheet" href="css/login.css"> 

<h2>Modal Login Form</h2>

<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="pub_logincheck.php">
  
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="images/bjor.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
        <label for="inp_brukernavn"><b>Brukernavn</b></label>
        <input type="text" placeholder="Skriv inn brukernavn" id="inp_brukernavn" name="inp_brukernavn" required>

        <label for="inp_passord"><b>Passord</b></label>
        <input type="password" placeholder="Skriv inn passord" id="inp_passord" name="inp_passord" required>
        
      <button type="submit">Logg inn her</button>
<!--      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label> -->
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
<!--      <span class="psw">Forgot <a href="#">password?</a></span> -->
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
document.getElementById('id01').style.display='block'

</script>










