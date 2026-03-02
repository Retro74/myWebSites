<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekvens</title>
    <style>
    p {
    font-family: "Georgia", serif;
    line-height: 1.6;
    font-size: 1.1rem;
    color: #1a1a1a;
    width: 500px;
    background: #f5f2e8;
    border-left: 6px solid #b22222; /* norsk rødfarge */
    padding: 16px 20px;
    margin: 20px 0;

    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

    <?php
    if($_POST){
        if(isset($_SESSION["svar"]){
            $_SESSION["svar"]=$_POST["txt_svar"] . ":"
        }else{
                $_SESSION["svar"]+=$_POST["txt_svar"] . ":"
            }
    }

    if (isset($_SESSION["sekvensnummer"])){
        if ($_SESSION["sekvensnummer"] >= 4){
            $_SESSION["sekvensnummer"] = 0; } else {
        $_SESSION["sekvensnummer"]++;}
    }else{
        $_SESSION["sekvensnummer"]=0;} 
    

        $norgeshistorie = [ 
                    "De eldste sikre sporene etter mennesker i Norge stammer fra rundt 9500 f.Kr., da jeger‑ og fangstgrupper fulgte isens tilbaketrekning og etablerte seg langs kysten. I årtusener levde folk av jakt, fiske og sanking før jordbruket gradvis ble innført i yngre steinalder, og senere utviklet bronsealderen og jernalderen mer komplekse samfunn med høvdingmakt og økt kontakt med Europa.", 
                    "I vikingtiden (ca. 800–1050) ble Norge en del av et større nordatlantisk handels- og ekspansjonsnettverk. Vikingene reiste, handlet og plyndret, og det vokste fram sterkere politiske strukturer. Rundt år 900 samlet Harald Hårfagre store deler av landet under én konge, og kristningen rundt år 1000 knyttet Norge tettere til europeiske makter og endret samfunnets lover og normer.",
                    "Middelalderen brakte både vekst og kriser. Høymiddelalderen var preget av sterk kongemakt og økt organisering, men svartedauden på 1300‑tallet tok livet av en tredjedel til halvparten av befolkningen og svekket landet dramatisk. I 1380 gikk Norge inn i union med Danmark, en forbindelse som varte i over 400 år og førte til at mye av styringen ble flyttet ut av landet.",
                    "I 1814 brøt unionen sammen etter Napoleonskrigene, og Norge fikk sin egen grunnlov på Eidsvoll. Landet ble likevel tvunget inn i en ny union med Sverige, men beholdt stor grad av selvstyre. Gjennom 1800‑tallet vokste nasjonal identitet, demokrati og industri fram, og i 1905 ble unionen med Sverige oppløst, slik at Norge igjen ble et selvstendig rike.",
                    "1900‑tallet var preget av modernisering, krig og velstandsbygging. Tysk okkupasjon under andre verdenskrig satte dype spor, men etter 1945 utviklet Norge en sterk velferdsstat og vendte seg mot vestlige allianser. Oljealderen fra slutten av 1960‑tallet endret økonomien dramatisk og gjorde landet til en av verdens rikeste stater, samtidig som debatten om ressursforvaltning og bærekraft ble stadig viktigere."];
        
        $norgeshistorie_quiz = [ 
                    "Hvor etablerte de første bosetningene seg rundt 9500 f.Kr. i Norge?", 
                    "Hvem samlet Norge til ett rike?",
                    "Hva heter sykdommen som på 1300‑tallet tok livet av befolkningen og svekket landet dramatisk?",
                    "Hvor fikk Norge  sin egen grunnlov?",
                    "Hvilket land okkuperte Norge under 1. verdenskrig?"];
        
        echo("<p>" . $norgeshistorie[$_SESSION["sekvensnummer"]] . "</p>");
    ?>

<?php if ($_SESSION["sekvensnummer"] < 4){ ?>
    <a href="oppg3_sekvens.php">Neste side <?php echo($_SESSION["sekvensnummer"] +1) ?></a>
<?php }else{ ?>
    <a href="oppg3_sekvens_oppsumering.php">Oppsummering</a>
<?php } ?>

<form metod="post">
    Svar:<input type="text" name="txt_svar" id="txt_svar"><button type="submit">Svar</button>
</form>
</body>
</html>