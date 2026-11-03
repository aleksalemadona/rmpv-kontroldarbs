<?php
    require_once('data.php');
    require_once('index.php');

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursu pieteikuma kalkulators</title>
</head>
<body>
    <h1>Kursu pieteikumu kalkulators</h1>

    <table>
        <tr>
            <?php
                foreach ($kursi as $kursa_kods => $kursa_dati){
            ?>
            <th>
                <?= $kursa_dati['nosaukums']; ?>
            </th>
            <?php
                }
            ?>      
        </tr>
        <tr>
            <?php
            foreach ($kursi as $kursa_kods => $kursa_dati){
            ?>
            <td>
                <?= $kursa_dati['cena']; ?> Eur
            </td>
            <?php
            }
            ?>      
    </table>

    <p>Ir pieejami <?= count($kursi) ?> dažādi kursi. </p>

</body>
<footer></footer>
</html>
