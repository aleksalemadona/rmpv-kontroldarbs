<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


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

    <?php
    $errors = [];
    $vards = "";
    $epasts = "";
    $kurss = "";
    $skaits = 0;

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
            "options" => ["min_range" => 1, "max_range" => 5]
        ]);
        if ($skaits_ok === false) {
            $errors["skaits"] = "Nav izvēlēts atļautais dalībnieku skaits";
        }
    }

    if ($errors === []) {
        var_dump("viss ok");
        
    }else{
        var_dump($errors);
    }

    ?>

    <form method="POST" action="">
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
