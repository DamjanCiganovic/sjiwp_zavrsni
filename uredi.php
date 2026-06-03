<?php
include "db.php";

$id = (int)$_GET['id'];

// === Obrada forme ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $naziv = trim($_POST['naziv']);
    $datum = $_POST['datum'];
    $vrijeme_pocetka = $_POST['vrijeme_pocetka'];
    $vrijeme_kraja = $_POST['vrijeme_kraja'];
    $broj_igraca = (int)$_POST['broj_igraca'];
    $status = trim($_POST['status']);
    $opis = trim($_POST['opis']);

    // UPDATE upit
    $stmt = $conn->prepare("
        UPDATE Dogadaji
        SET
            naziv = ?,
            datum = ?,
            vrijeme_pocetka = ?,
            vrijeme_kraja = ?,
            broj_igraca = ?,
            status = ?,
            opis = ?
        WHERE ID_dogadaj = ?
    ");

    $stmt->bind_param(
        "ssssissi",
        $naziv,
        $datum,
        $vrijeme_pocetka,
        $vrijeme_kraja,
        $broj_igraca,
        $status,
        $opis,
        $id
    );

    if ($stmt->execute()) {

        header("Location: index.php?poruka=azurirano");
        exit;

    } else {

        echo "Greška: " . $conn->error;

    }
}

// === Dohvati postojeće podatke ===
$stmt = $conn->prepare("
    SELECT *
    FROM Dogadaji
    WHERE ID_dogadaj = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$dogadaj = $stmt->get_result()->fetch_assoc();

if (!$dogadaj) {
    die("Događaj ne postoji.");
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <link rel="stylesheet" href="stil.css">
    <meta charset="UTF-8">
    <title>Uredi događaj</title>
</head>
<body>

<h1>Uredi događaj #<?= $id ?></h1>

<form method="POST">

    <label>
        Naziv događaja:
        <input type="text"
               name="naziv"
               value="<?= htmlspecialchars($dogadaj['naziv']) ?>"
               required>
    </label>

    <br><br>

    <label>
        Datum:
        <input type="date"
               name="datum"
               value="<?= $dogadaj['datum'] ?>"
               required>
    </label>

    <br><br>

    <label>
        Vrijeme početka:
        <input type="time"
               name="vrijeme_pocetka"
               value="<?= $dogadaj['vrijeme_pocetka'] ?>"
               required>
    </label>

    <br><br>

    <label>
        Vrijeme kraja:
        <input type="time"
               name="vrijeme_kraja"
               value="<?= $dogadaj['vrijeme_kraja'] ?>"
               required>
    </label>

    <br><br>

    <label>
        Broj igrača:
        <input type="number"
               name="broj_igraca"
               value="<?= $dogadaj['broj_igraca'] ?>"
               required>
    </label>

    <br><br>

    <label>
        Status:
        <select name="status">

            <option value="Otvoren"
                <?= $dogadaj['status'] == 'Otvoren' ? 'selected' : '' ?>>
                Otvoren
            </option>

            <option value="Popunjen"
                <?= $dogadaj['status'] == 'Popunjen' ? 'selected' : '' ?>>
                Popunjen
            </option>

            <option value="Najavljen"
                <?= $dogadaj['status'] == 'Najavljen' ? 'selected' : '' ?>>
                Najavljen
            </option>

            <option value="Završen"
                <?= $dogadaj['status'] == 'Završen' ? 'selected' : '' ?>>
                Završen
            </option>

        </select>
    </label>

    <br><br>

    <label>
        Opis:
        <textarea name="opis"><?= htmlspecialchars($dogadaj['opis']) ?></textarea>
    </label>

    <br><br>

    <button type="submit">💾 Spremi izmjene</button>

    <a href="index.php">Odustani</a>

</form>

</body>
</html>