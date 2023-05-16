<?php session_start(); 
include 'dbConnection.php'; 
$uspjesnaPrijava = false;
// Putanja do direktorija sa slikama 
define('UPLPATH', 'images/'); 
// Provjera da li je korisnik došao s login forme 
if (isset($_POST['prijava'])) { 
   // Provjera da li korisnik postoji u bazi uz zaštitu od SQL injectiona 
   $prijavaImeKorisnika = $_POST['username']; 
   $prijavaLozinkaKorisnika = $_POST['lozinka'];
   $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?"; 
   $stmt = mysqli_stmt_init($dbc); 
   if (mysqli_stmt_prepare($stmt, $sql)) { 
      mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika); 
      mysqli_stmt_execute($stmt); 
      mysqli_stmt_store_result($stmt); 
   } 
   mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika); 
   mysqli_stmt_fetch($stmt); 
   //Provjera lozinke 
   if (password_verify($_POST['lozinka'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) { 
      $uspjesnaPrijava = true;
      // Provjera da li je admin 
      if($levelKorisnika == 1) { 
         $admin = true; 
         } else { 
            $admin = false; 
            } //postavljanje session varijabli 
            $_SESSION['$username'] = $imeKorisnika; 
            $_SESSION['$level'] = $levelKorisnika; 
            } else { 
               $uspjesnaPrijava = false; 
            } 
} 
// Pokaži stranicu ukoliko je korisnik uspješno prijavljen i administrator je 
if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) { 
   $query = "SELECT * FROM vijesti"; 
   $result = mysqli_query($dbc, $query); 
   while($row = mysqli_fetch_array($result)) { 
      //forma za administraciju 
   } 
   // Pokaži poruku da je korisnik uspješno prijavljen, ali nije administrator 
} else if ($uspjesnaPrijava == true && $admin == false) { 
   echo '<p>Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali niste administrator.</p>'; 
} else if (isset($_SESSION['$username']) && $_SESSION['$level'] == 0) {
   echo '<p>Bok ' . $_SESSION['$username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>'; 
   } else if ($uspjesnaPrijava == false) { 
      ?> 
      

      <section role="main"> 
         <form enctype="multipart/form-data" action="" method="POST"> 
            <div class="form-item"> 
               <span id="porukaIme" class="bojaPoruke"></span> 
               <label for="title">Ime: </label> 
               <div class="form-field"> 
                  <input type="text" name="ime" id="ime" class="form-field-textual"> 
               </div> 
            </div> 
            <div class="form-item"> 
               <span id="porukaPrezime" class="bojaPoruke"></span> 
               <label for="about">Prezime: </label> 
               <div class="form-field"> 
                  <input type="text" name="prezime" id="prezime" class="form-field-textual"> 
               </div> 
            </div> 
            <div class="form-item"> 
               <span id="porukaUsername" class="bojaPoruke"></span> 
               <label for="content">Korisničko ime:</label> 
               <!-- Ispis poruke nakon provjere korisničkog imena u bazi --> 
                
               <div class="form-field"> 
                  <input type="text" name="username" id="username" class="form-field-textual"> 
               </div> 
            </div> 
            <div class="form-item"> 
               <span id="porukaPass" class="bojaPoruke"></span> 
               <label for="pphoto">Lozinka: </label> 
               <div class="form-field">
                  <input type="password" name="pass" id="pass" class="form-field-textual"> 
               </div> 
            </div> 
            <div class="form-item"> 
               <span id="porukaPassRep" class="bojaPoruke"></span> 
               <label for="pphoto">Ponovite lozinku: </label> 
               <div class="form-field"> 
                  <input type="password" name="passRep" id="passRep" class="form-field-textual"> 
               </div> 
            </div> 
            <div class="form-item"> 
               <button type="submit" value="Prijava" id="slanje">Prijava</button> 
            </div> 
         </form> 
      </section>
      <script type="text/javascript"> 
   
      
         document.getElementById("slanje").onclick = function(event) { 
            var slanjeForme = true; // Ime korisnika mora biti uneseno 
            var poljeIme = document.getElementById("ime"); 
            var ime = document.getElementById("ime").value; 
            if (ime.length == 0) { 
               slanjeForme = false; 
               poljeIme.style.border="1px dashed red"; 
               document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>"; 
            } else { 
               poljeIme.style.border="1px solid green"; 
               document.getElementById("porukaIme").innerHTML=""; 
            } // Prezime korisnika mora biti uneseno 
            var poljePrezime = document.getElementById("prezime"); 
            var prezime = document.getElementById("prezime").value; 
            if (prezime.length == 0) { 
               slanjeForme = false;
               poljePrezime.style.border="1px dashed red"; 
               document.getElementById("porukaPrezime").innerHTML="<br>Unesite Prezime!<br>"; 
            } else { 
               poljePrezime.style.border="1px solid green"; 
               document.getElementById("porukaPrezime").innerHTML=""; } 
               // Korisničko ime mora biti uneseno 
               var poljeUsername = document.getElementById("username"); 
               var username = document.getElementById("username").value; 
               if (username.length == 0) { 
                  slanjeForme = false; 
                  poljeUsername.style.border="1px dashed red"; 
                  document.getElementById("porukaUsername").innerHTML="<br>Unesite korisničko ime!<br>"; 
               } else { 
                  poljeUsername.style.border="1px solid green"; 
                  document.getElementById("porukaUsername").innerHTML=""; 
               } 
               // Provjera podudaranja lozinki 
               var poljePass = document.getElementById("pass"); 
               var pass = document.getElementById("pass").value; 
               var poljePassRep = document.getElementById("passRep"); 
               var passRep = document.getElementById("passRep").value; 
               if (pass.length == 0 || passRep.length == 0 || pass != passRep) { 
                  slanjeForme = false; 
                  poljePass.style.border="1px dashed red"; 
                  poljePassRep.style.border="1px dashed red"; 
                  document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>"; 
                  document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>"; 
               } else { 
                  poljePass.style.border="1px solid green"; 
                  poljePassRep.style.border="1px solid green"; 
                  document.getElementById("porukaPass").innerHTML=""; 
                  document.getElementById("porukaPassRep").innerHTML=""; 
               } if (slanjeForme != true) { 
                  event.preventDefault(); 
               }
            };

      </script> 
      <?php } ?>
