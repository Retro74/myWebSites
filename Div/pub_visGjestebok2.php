




<h1>Gjestebok</h1>
<?php
    //SQL-spørringen 
    $sql = "SELECT * FROM tbl_gjestebok";
    //Kjører spørringen mot databasen og resultatet settes i datasettet 
    $datasett = $tilkobling->query($sql);
?>


<!-- For hver rad i datasettet, lager PHPkoden en rad i HTML-tabelen ,
med kolonner for feltene: bruker_id, innlegg, dato_tid, husnummer, mailadresse-->
<table class="w3-table-all w3-table-all w3-hoverable">
    <tr>
        <th>Brukernavn</th>
        <th>Innlegg</th>
        <th>Dato</th>

    </tr>
    <?php while($rad = mysqli_fetch_array($datasett)) { ?>
        <tr>
            <td><?php echo $rad["Brukernavn"]; ?></td>
            <td><?php echo $rad["Innlegg"]; ?></td>
            <td><?php echo $rad["Dato"]; ?></td>

        </tr>
    <?php } ?>
</table>


