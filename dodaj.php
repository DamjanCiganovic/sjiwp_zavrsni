<?php
include "db.php";

// === Obrada forme ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Dohvati podatke
    $naziv = trim($_POST['naziv']);
    $datum = $_POST['datum'];
    $vrijeme_pocetka = $_POST['vrijeme_pocetka'];
    $vrijeme_kraja = $_POST['vrijeme_kraja'];
    $broj_igraca = (int)$_POST['broj_igraca'];
    $status = trim($_POST['status']);
    $opis = trim($_POST['opis']);

    // Jednostavna validacija
    if ($naziv === '' || $broj_igraca <= 0) {

        $greska = "Naziv je obavezan, a broj igrača mora biti veći od 0.";

    } else {

        // INSERT u Dogadaji
        $stmt = $conn->prepare("
            INSERT INTO Dogadaji
            (naziv, datum, vrijeme_pocetka, vrijeme_kraja,
             broj_igraca, status, opis)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssiss",
            $naziv,
            $datum,
            $vrijeme_pocetka,
            $vrijeme_kraja,
            $broj_igraca,
            $status,
            $opis
        );

        if ($stmt->execute()) {

            header("Location: index.php?poruka=dodano");
            exit;

        } else {

            $greska = "Greška: " . $conn->error;

        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <link rel="stylesheet" href="stil.css">
    <meta charset="UTF-8">
    <title>Novi događaj</title>
</head>
<body>

<h1>Dodaj novi sportski događaj</h1>

<?php if (!empty($greska)): ?>
    <p style="color:red"><?= $greska ?></p>
<?php endif; ?>

<form method="POST" action="dodaj.php">

    <label>
        Naziv događaja:
        <input type="text" name="naziv" required>
    </label>

    <br><br>

    <label>
        Datum:
        <input type="date" name="datum" required>
    </label>

    <br><br>

    <label>
        Vrijeme početka:
        <input type="time" name="vrijeme_pocetka" required>
    </label>

    <br><br>

    <label>
        Vrijeme kraja:
        <input type="time" name="vrijeme_kraja" required>
    </label>

    <br><br>

    <label>
        Broj igrača:
        <input type="number" name="broj_igraca" required>
    </label>

    <br><br>

    <label>
        Status:
        <select name="status">
            <option value="Otvoren">Otvoren</option>
            <option value="Popunjen">Popunjen</option>
            <option value="Najavljen">Najavljen</option>
            <option value="Završen">Završen</option>
        </select>
    </label>

    <br><br>

    <label>
        Opis:
        <textarea name="opis"></textarea>
    </label>

    <br><br>

    <button type="submit">💾 Spremi</button>

    <a href="index.php">Odustani</a>

</form>

</body>
</html>