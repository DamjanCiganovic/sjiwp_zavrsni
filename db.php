<?php
// =====================================================
// SPAJANJE NA BAZU PODATAKA
// =====================================================
// Postavke prilagodite vašoj bazi:
$host     = "localhost";    // server (kod kuće uvijek localhost)
$korisnik = "root";         // korisnik (XAMPP standardno: root)
$lozinka  = "";             // lozinka (XAMPP standardno: prazno)
$baza     = "SportSquad";    // ◄── PROMIJENITE: ime vaše baze

// Spajanje
$conn = new mysqli($host, $korisnik, $lozinka, $baza);

// Provjera spajanja
if ($conn->connect_error) {
    die("Greška pri spajanju: " . $conn->connect_error);
}

// Hrvatska slova (č, ć, š, đ, ž)
$conn->set_charset("utf8mb4");
?>