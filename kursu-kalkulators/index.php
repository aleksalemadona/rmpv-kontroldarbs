<?php

    require_once('data.php');
    require_once('functions.php');

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" type="text/css" rel="stylesheet" />
    <title>Kursu pieteikuma kalkulators</title>
</head>
<body>
    <div class="container">

        <?php

        $errors = [];
        $vards = "";
        $epasts = "";
        $kurss = "";
        $skaits = 0;
        $kursa_cena = 0;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $vards = trim($_POST["vards"] ?? "");
            $epasts = trim($_POST["epasts"] ?? "");
            $kurss = trim($_POST["kurss"] ?? "");
            $skaits = trim($_POST["skaits"] ?? "");

            if ($vards === "") {
                $errors["vards"] = "Vārds ir obligāts.";
            }

            if (!filter_var($epasts, FILTER_VALIDATE_EMAIL)) {
                $errors["epasts"] = "Nederīgs e-pasts.";
            }

            if (!array_key_exists($kurss, $kursi)){
                $errors["kursi"] = "Tāds kurss neeksistē";
            }


            $skaits_ok = filter_var($skaits, FILTER_VALIDATE_INT, [
                "options" => ["min_range" => 1, "max_range" => $max_dalibnieku_skaits]
            ]);
            if ($skaits_ok === false) {
                $errors["skaits"] = "Nav izvēlēts atļautais dalībnieku skaits";
            }

            if ($errors === []) {
        
                foreach ($kursi as $kursa_kods => $kursa_dati){
                    if ($kursa_kods == $kurss){
                        $kursa_cena = $kursa_dati['cena'];
                        $kursa_nosaukums = $kursa_dati['nosaukums'];
                    }
                }
        
                $kursu_summa = (kursuSumma($kursa_cena, $skaits, $atlaide_no, $atlaide));


        ?>
            <div class="popup">
                <h3> Sveiki, <?= $vards; ?> </h3>
                <p>Uz jūsu e-pastu <b><?= $epasts; ?></b> ir nosūtīts rēķins apmaksai par kursiem:</p>
                <p><b><?= $kursa_nosaukums; ?></b>, <?= $skaits; ?> personām</p>
                <p>Starpsumma: <?= number_format($kursu_summa['starpsumma'],2); ?></p>
                <p>Atlaide: <?= number_format($kursu_summa['atlaide'],2); ?></p>
                <p>Summa kopā: <?= number_format($kursu_summa['gala_summa'],2); ?></p>
                <p><a href="index.php">Aizvērt</a></p>
            </div>
        <?php

            }
        }

        ?>

        <h1>Kursu pieteikumu kalkulators</h1>

        <div class="table-block">
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
                        <?= number_format($kursa_dati['cena'],2); ?> Eur
                    </td>
                    <?php
                    }
                    ?>      
            </table>

            <p>Ir pieejami <?= count($kursi) ?> dažādi kursi. </p>
            <?php
            if ($atlaide_no > 0){
            ?>
                <p>*Atlaide  <?= $atlaide; ?>% ja piesakās <?= $atlaide_no; ?> un vairāk pretendenti </p>
            <?php
            }
            ?>
        </div>

        <div class="form-block">

            <h2>Aizpildi formu</h2>

            <form id="kursu-forma" method="POST" action="">
                <?php if (isset($errors["vards"])): ?>
                    <p class="error"><?= htmlspecialchars($errors["vards"]) ?></p>
                <?php endif; ?>
                <input id="vards" type="text" name="vards" placeholder="Jūsu vārds" value="<?= htmlspecialchars($vards, ENT_QUOTES, 'UTF-8') ?>">
                <?php if (isset($errors["epasts"])): ?>
                    <p class="error"><?= htmlspecialchars($errors["epasts"]) ?></p>
                <?php endif; ?>
                <input id="epasts" type="email" name="epasts" placeholder="Jūsu ēpasts" value="<?= htmlspecialchars($epasts, ENT_QUOTES, 'UTF-8') ?>">
                <?php if (isset($errors["kurss"])): ?>
                    <p class="error"><?= htmlspecialchars($errors["kurss"]) ?></p>
                <?php endif; ?>
                <select id="kurss" name="kurss">
                    <?php
                    foreach ($kursi as $kursa_kods => $kursa_dati){
                                                
                        $selected = "";

                        if ($kursa_kods == $kurss){
                            $selected = 'selected';
                        }
                    ?>
                        <option <?= $selected; ?> value="<?= htmlspecialchars($kursa_kods, ENT_QUOTES, 'UTF-8'); ?>">
                            <?= htmlspecialchars($kursa_dati['nosaukums'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php
                    }
                    ?>  
                </select>
                <?php if (isset($errors["skaits"])): ?>
                    <p class="error"><?= htmlspecialchars($errors["skaits"]) ?></p>
                <?php endif; ?>
                <select id="skaits" name="skaits">
                    <?php
                    for($i = 0; $i <= $max_dalibnieku_skaits; $i++){
                        
                    $selected = "";

                        if ($i == $skaits){
                            $selected = 'selected';
                        }
                    ?>
                        <option <?= $selected; ?> value="<?= htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>
                    <?php
                    }
                    ?>
                </select>

                <button type="submit">Iesniegt</button>
            </form>

        </div>

    </div>
</body>
<footer></footer>
</html>
