<?php
session_start();
include 'dbConnection.php';
// Putanja do direktorija sa slikama
define('UPLPATH', 'images/');
// Provjera da li je korisnik došao s login forme
if (isset($_POST['prijava'])) {
 // Provjera da li korisnik postoji u bazi uz zaštitu od SQL injectiona
 $prijavaImeKorisnika = $_POST['username'];
 $prijavaLozinkaKorisnika = $_POST['lozinka'];
 $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik
 WHERE korisnicko_ime = ?";
 $stmt = mysqli_stmt_init($dbc);
 if (mysqli_stmt_prepare($stmt, $sql)) {
 mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
 mysqli_stmt_execute($stmt);
 mysqli_stmt_store_result($stmt);
 }
 mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika,$levelKorisnika);
 mysqli_stmt_fetch($stmt);
 //Provjera lozinke
 if (password_verify($_POST['lozinka'], $lozinkaKorisnika) &&
mysqli_stmt_num_rows($stmt) > 0) {
 $uspjesnaPrijava = true;
 // Provjera da li je admin
 if($levelKorisnika == 1) {
    $admin = true;
    }
    else {
    $admin = false;
    }
    //postavljanje session varijabli
    $_SESSION['$username'] = $imeKorisnika;
    $_SESSION['$level'] = $levelKorisnika;
    } else {
    $uspjesnaPrijava = false;
    }
   
   }
   // Brisanje i promijena arhiviranosti
   ?>

<?php
 // Pokaži stranicu ukoliko je korisnik uspješno prijavljen i administrator je
 if (($uspjesnaPrijava == true && $admin == true) ||
(isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) {
 $query = "SELECT * FROM vijesti";
 $result = mysqli_query($dbc, $query);
 while($row = mysqli_fetch_array($result)) {

 //forma za administraciju
 }
 // Pokaži poruku da je korisnik uspješno prijavljen, ali nije administrator
 } else if ($uspjesnaPrijava == true && $admin == false) {

 echo '<p>Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali
niste administrator.</p>';
 } else if (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
    echo '<p>Bok ' . $_SESSION['$username'] . '! Uspješno ste
prijavljeni, ali niste administrator.</p>';
 } else if ($uspjesnaPrijava == false) {
 ?>
 <!-- Forma za prijavu -->
 <script type="text/javascript">

 //javascript validacija forme

 </script>

 <?php
 }
 ?>
