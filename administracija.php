<?php
session_start();
include 'dbConnection.php';

if(isset($_SESSION['username']) && isset($_SESSION['razina'])) {
   $sessionUsername = $_SESSION['username'];
   $sessionRazina = $_SESSION['razina'];

   if ($sessionRazina == 0) {
    header("Location: index.php");
    exit;
   } else {
      header("Location: index.php?menu=5");
      exit;
   }

}


if (isset($_POST['submit'])) {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka = $_POST['pass'];
    $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
    $razina = 0;
    $registriranKorisnik = '';

    // Provjera postoji li u bazi već korisnik s tim korisničkim imenom
    $sql = "SELECT username FROM korisnik WHERE username = ?";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
    }

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $msg = 'Korisničko ime već postoji!';
    } else {
        // Ako ne postoji korisnik s tim korisničkim imenom - Registracija korisnika u bazi pazeći na SQL injection
        $sql = "INSERT INTO korisnik (ime, prezime, username, pass, razina) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($dbc);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina);
            mysqli_stmt_execute($stmt);
            $registriranKorisnik = true;
        }
    }

    mysqli_close($dbc);
}

if (isset($_POST['submitLogin'])) {
   $usernameLogin = $_POST['usernameLogin'];
   $passLogin = $_POST['passLogin'];

   if($_POST['usernameLogin'] != "" && $_POST['passLogin'] != "") {
   // Provjerite korisnika u bazi podataka
   $sql = "SELECT * FROM korisnik WHERE username = ?";
   $stmt = mysqli_stmt_init($dbc);

   if (mysqli_stmt_prepare($stmt, $sql)) {
       mysqli_stmt_bind_param($stmt, 's', $usernameLogin);
       mysqli_stmt_execute($stmt);
       $result = mysqli_stmt_get_result($stmt);
       $user = mysqli_fetch_assoc($result);
       // Provjerite lozinku korisnika
       if ($user && password_verify($passLogin, $user['pass'])) {
         print 'Provjera uspješna';
           // Uspješna prijava - postavite korisničke podatke u sesiju
           $_SESSION['username'] = $user['username'];
           $_SESSION['razina'] = $user['razina'];
           // Preusmjerite korisnika na početnu stranicu ili neku drugu stranicu nakon prijave
           header("Location: index.php");
           exit();
       } else {
         print 'Provjera nije uspješna';
           // Neuspješna prijava - prikažite poruku ili poduzmite odgovarajuće radnje
           $msg = 'Pogrešno korisničko ime ili lozinka.';
       }
   }

   mysqli_close($dbc);
   }

}

?>
<div class="forms-container">
    <section class="login-body section-login">
      <h4>Registracija</h4>
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="form-item">
                <span id="porukaIme" class="bojaPoruke"></span>
                <label for="title">Ime: </label>
                <div class="form-field-label">
                    <input type="text" name="ime" id="ime" class="form-field-input">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaPrezime" class="bojaPoruke"></span>
                <label for="about">Prezime: </label>
                <div class="form-field-label">
                    <input type="text" name="prezime" id="prezime" class="form-field-input">
                </div>
            </div>
            <div class="form-item">
                <span id="porukaUsername" class="bojaPoruke"><?php if (
            isset($msg)) echo $msg; ?></span>
            <label for="content">Korisničko ime:</label>
            <!-- Ispis poruke nakon provjere korisničkog imena u bazi -->
            <div class="form-field-label">
                <input type="text" name="username" id="username" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <span id="porukaPass" class="bojaPoruke"></span>
            <label for="pphoto">Lozinka: </label>
            <div class="form-field-label">
                <input type="password" name="pass" id="pass" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <span id="porukaPassRep" class="bojaPoruke"></span>
            <label for="pphoto">Ponovite lozinku: </label>
            <div class="form-field-label">
                <input type="password" name="passRep" id="passRep" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <button type="submit" name="submit" value="Prijava" id="slanje">Registracija</button>
        </div>
        </form>

        <h4>Prijava</h4>
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="form-item">
                <span id="porukaUsernameLogin" class="bojaPoruke"><?php if (
            isset($msg)) echo $msg; ?></span>
            <label for="content">Korisničko ime:</label>
            <div class="form-field-label">
                <input type="text" name="usernameLogin" id="usernameLogin" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <span id="porukaPassLogin" class="bojaPoruke"></span>
            <label for="pphotoLogin">Lozinka: </label>
            <div class="form-field-label">
                <input type="password" name="passLogin" id="passLogin" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <button type="submit" name="submitLogin" value="Registracija" id="login">Prijava</button>
        </div>
    </form>
</section>
</div>
<script type="text/javascript">
    document.getElementById("slanje").onclick = function (event) {
        var slanjeFormeReg = true;

        // Ime korisnika mora biti uneseno
        var poljeIme = document.getElementById("ime");
        var ime = document.getElementById("ime").value;

        if (ime.length == 0) {
         slanjeFormeReg = false;
            poljeIme.style.border = "1px dashed red";
            document.getElementById("porukaIme").innerHTML = "<br>Unesite ime!<br>";
        } else {
            poljeIme.style.border = "1px solid green";
            document.getElementById("porukaIme").innerHTML = "";
        }

        // Prezime korisnika mora biti uneseno
        var poljePrezime = document.getElementById("prezime");
        var prezime = document.getElementById("prezime").value;

        if (prezime.length == 0) {
         slanjeFormeReg = false;
            poljePrezime.style.border = "1px dashed red";
            document.getElementById("porukaPrezime").innerHTML = "<br>Unesite Prezime!<br>";
        } else {
            poljePrezime.style.border = "1px solid green";
            document.getElementById("porukaPrezime").innerHTML = "";
        }

        // Korisničko ime mora biti uneseno
        var poljeUsername = document.getElementById("username");
        var username = document.getElementById("username").value;

        if (username.length == 0) {
         slanjeFormeReg = false;
            poljeUsername.style.border = "1px dashed red";
            document.getElementById("porukaUsername").innerHTML = "<br>Unesite korisničko ime!<br>";
        } else {
            poljeUsername.style.border = "1px solid green";
            document.getElementById("porukaUsername").innerHTML = "";
        }

        // Provjera podudaranja lozinki
        var poljePass = document.getElementById("pass");
        var pass = document.getElementById("pass").value;
        var poljePassRep = document.getElementById("passRep");
        var passRep = document.getElementById("passRep").value;
        if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
         slanjeFormeReg = false;
            poljePass.style.border = "1px dashed red";
            poljePassRep.style.border = "1px dashed red";
            document.getElementById("porukaPass").innerHTML = "<br>Lozinke nisu iste!<br>";
            document.getElementById("porukaPassRep").innerHTML = "<br>Lozinke nisu iste!<br>";
        } else {
            poljePass.style.border = "1px solid green";
            poljePassRep.style.border = "1px solid green";
            document.getElementById("porukaPass").innerHTML = "";
            document.getElementById("porukaPassRep").innerHTML = "";
        }

        if (slanjeFormeReg != true) {
            event.preventDefault();
        }
    };


    document.getElementById("login").onclick = function (event) {
        var slanjeForme = true;

        var poljeUsername = document.getElementById("usernameLogin");
        var username = document.getElementById("usernameLogin").value;

        if (username.length == 0) {
            slanjeForme = false;
            poljeUsername.style.border = "1px dashed red";
            document.getElementById("porukaUsernameLogin").innerHTML = "<br>Unesite korisničko ime!<br>";
        } else {
            poljeUsername.style.border = "1px solid green";
            document.getElementById("porukaUsernameLogin").innerHTML = "";
        }

        var poljePass = document.getElementById("passLogin");
        var pass = document.getElementById("passLogin").value;
        if (pass.length == 0) {
            slanjeForme = false;
            poljePass.style.border = "1px dashed red";
            poljePassRep.style.border = "1px dashed red";
            document.getElementById("porukaPassLogin").innerHTML = "<br>Lozinka nije unesena!<br>";
        } else {
            poljePass.style.border = "1px solid green";
            poljePassRep.style.border = "1px solid green";
            document.getElementById("porukaPassLogin").innerHTML = "";
        }

        if (slanjeForme != true) {
            event.preventDefault();
        }
    };

</script>
