<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie-Manager</title>
</head>
<body>
    <h1>JS-del</h1>
    <input type="text" id="cookieName" placeholder="Cookie-navn">
    <input type="text" id="cookievalue" placeholder="Cookie-verdi"><br>
    <button onclick="lagreCookie()">Lagre Cookie</button>
    <button onclick="visCookies()">Hent Cookies</button><br>
    <button onclick="slettCookie()">Slett Cookies med navn</button>
    <button onclick="slettAlleCookies()">Slett alle Cookies</button><br>

<div style="background: #fff3cd; border: 1px solid #ffc107; padding:5px; border-radius: 4px; margin-top: 1rem;"><h3>🍪 My Cookies (lest av JS) 🍪</h3>
<div id="output_js" ></div>
</div>
<br>
    <h1>PHP-del</h1>

<form action="cookie_Oppgave0.php" method="POST"><input type="submit" value="Les alle Cookies med PHP"></form>
<form method="GET"><input type="submit" value="Les verdien til Cookies med PHP som heter: "> <input type="text" id="readCookieWithName" name="readCookieWithName"></form>
<form action="cookie_Oppgave0.php" method="POST"><input type="text" id="sendCookieName" name="sendCookieName" placeholder="Cookie-navn"><input type="text" id="sendCookievalue" name="sendCookievalue" placeholder="Cookie-verdi"><br>
    <input type="submit" value="Lag Cookie med PHP"></form>

<div style="background:rgb(205, 218, 255); border: 1px solidrgb(23, 7, 255); padding:5px; border-radius: 4px; margin-top: 1rem;"><h3>🍪 My Cookies (lest av PHP) 🍪</h3>
<div id="output_php" >
    <?php 
    if (isset($_GET["readCookieWithName"]) && $_GET["readCookieWithName"] != ""){
        echo($_GET["readCookieWithName"] . " = " . $_COOKIE[$_GET["readCookieWithName"]]);
    }else{
        if (isset($_POST["sendCookieName"]) && $_POST["sendCookieName"]!="" && $_POST["sendCookievalue"] != ""){
            setcookie($_POST["sendCookieName"], $_POST["sendCookievalue"], time() + (3600*24*30), '/');
        }
        foreach ($_COOKIE as $navn => $verdi) {
            echo $navn . ' = ' . $verdi . '<br>';
        } 
    } ?>
</div>
</div>
 
<script>
function lagreCookie() {
    const utloper = new Date();
    utloper.setDate(utloper.getDate() + 30);
    document.cookie = cookieName.value + "=" + cookievalue.value + ";  expires=" + utloper.toUTCString() + "; path=/";
    }
function visCookies() {
    document.getElementById("output_js").innerText ="";
    document.cookie.split('; ').forEach(cookie => {
        document.getElementById("output_js").innerText += cookie + "\n";});
     }

function slettAlleCookies(){
    document.cookie.split('; ').forEach(cookie => {
        const navn = cookie.split('=')[0];
        document.cookie = navn + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
    });
}
function slettCookie() {
    document.cookie = cookieName.value + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
    }
function getCookie(navn) {
    const cookie_array = document.cookie.split('; ');
    for (const cookie of cookie_array) {
        const [n, v] = cookie.split('=');
        if (n === navn) return decodeURIComponent(v);
    }
    return null;
}
window.onload = function() {
    visCookies();};
</script>
</body>
</html>