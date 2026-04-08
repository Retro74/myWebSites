
<?php
if (isset($_SERVER['REQUEST_URI'])){
    $url = $_SERVER['REQUEST_URI'];
}else {
    $url = 'N/A';
}

if (isset($_SERVER['REMOTE_ADDR'])){
    $remoteIP = $_SERVER['REMOTE_ADDR'];
}else {
    $remoteIP = 'N/A';
}
if(isset($_SESSION["brukernavn"])){
    $brukernavn = $_SESSION["brukernavn"];
}else{
    $brukernavn = "Anonym";
}


$stmt = $tilkobling->prepare(
    "INSERT INTO tbl_besokslogg
    (Webside, KlientIP, Brukernavn)
    VALUES (?, ?, ?)"
    );

// Bind parametere fra POST-data

$stmt->bind_param("sss",
    $url,
    $remoteIP,
    $brukernavn
);

// Kjør spørringen

$stmt->execute();
$stmt->close();

?>