<?php
include "db.php";

// Dohvati ID iz URL-a
$id = (int)($_GET['id'] ?? 0);

// Provjera ID-a
if ($id <= 0) {
    die("Neispravan ID događaja.");
}

// DELETE upit
$stmt = $conn->prepare("
    DELETE FROM Dogadaji
    WHERE ID_dogadaj = ?
");

// Bind ID-a
$stmt->bind_param("i", $id);

// Izvršavanje
if ($stmt->execute()) {

    header("Location: index.php?poruka=obrisano");
    exit;

} else {

    echo "Greška pri brisanju: " . $conn->error;

}

// Zatvaranje konekcije
$conn->close();
?>