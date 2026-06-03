<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <title>Popis događaja</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
<header class="glavni-header">
    <div class="header-kontejner">
        <!-- Logotip -->
        <div class="logo">
            <a href="index.php">
                <span class="logo-ikona">🏆</span> Sport<span class="logo-naglasak">Squad</span>
            </a>
        </div>
        
        <nav class="header-navigacija">
            <a href="index.php" class="nav-link">Prijava</a>
            <a href="index.php" class="nav-link">Početna</a>
            
        </nav>
    </div>
</header>

<h1>Popis sportskih događaja</h1>
<a href="dodaj.php">➕ Dodaj novi događaj</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Naziv događaja</th>
        <th>Datum</th>
        <th>Status</th>
        <th>Broj igrača</th>
        <th>Akcije</th>
    </tr>

<?php
// SQL upit za dohvat događaja
$sql = "SELECT ID_dogadaj, naziv, datum, status, broj_igraca 
        FROM Dogadaji 
        ORDER BY datum ASC";

$rezultat = $conn->query($sql);

// Provjera ima li podataka
if ($rezultat->num_rows > 0) {

    while ($red = $rezultat->fetch_assoc()) {
?>

    <tr>
        <td><?= $red['ID_dogadaj'] ?></td>

        <td><?= htmlspecialchars($red['naziv']) ?></td>

        <td><?= date("d.m.Y", strtotime($red['datum'])) ?></td>

        <td><?= htmlspecialchars($red['status']) ?></td>

        <td><?= $red['broj_igraca'] ?></td>

        <td>
            <a href="uredi.php?id=<?= $red['ID_dogadaj'] ?>">
                ✏️ Uredi
            </a>

            <a href="obrisi.php?id=<?= $red['ID_dogadaj'] ?>"
               onclick="return confirm('Sigurno obrisati događaj?')">
                🗑️ Obriši
            </a>
        </td>
    </tr>

<?php
    }

} else {
    echo "<tr><td colspan='6'>Nema događaja u bazi.</td></tr>";
}
?>

</table>

<div class="footer-wrapper">
    <footer class="glavni-footer">
        <div class="footer-kontejner">
            <p>&copy; <?= date("Y") ?> SportSquad. Sva prava pridržana.</p>
            <div class="footer-linkovi">
                <a href="#">Uvjeti korištenja</a>
                <a href="#">Privatnost</a>
                <a href="#">Kontakt</a>
            </div>
        </div>
    </footer>
</div>


<?php $conn->close(); ?>

</body>
</html>