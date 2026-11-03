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

    <h2>Aizpildi formu</h2>

    <form action="POST">
        <input id="vards" type="text" name="vards" placeholder="Jūsu vārds">
        <input id="epasts" type="email" name="epasts" placeholder="Jūsu ēpasts">
        <select id="kurss" name="kurss">
            <?php
            foreach ($kursi as $kursa_kods => $kursa_dati){
            ?>
                <option value="<?= $kursa_kods; ?>">
                    <?= $kursa_dati['nosaukums']; ?>
                </option>
            <?php
            }
            ?>  
        </select>
        <select id="skaits" name="skaits">
            <?php
            for($i = 0; $i <= $max_dalibnieku_skaits; $i++){
            ?>
                <option value="<?= $i; ?>"><?= $i; ?>
            <?php
            }
            ?>
        </select>

        <button type="submit">Iesniegt</button>
    </form>

</body>
<footer></footer>
</html>
