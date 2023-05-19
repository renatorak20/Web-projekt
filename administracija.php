<?php
if(!isset($_SESSION)) {
    session_start();
  }
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
        $sql = "INSERT INTO korisnik (ime, prezime, username, pass, razina) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($dbc);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina);
            mysqli_stmt_execute($stmt);
            $registriranKorisnik = true;

            $_SESSION['username'] = $username;
            $_SESSION['razina'] = $razina;
 
            header("Location: index.php");
            exit();

        }
    }

    mysqli_close($dbc);
}

if (isset($_POST['submitLogin'])) {
   $usernameLogin = $_POST['usernameLogin'];
   $passLogin = $_POST['passLogin'];

   if($_POST['usernameLogin'] != "" && $_POST['passLogin'] != "") {

   $sql = "SELECT * FROM korisnik WHERE username = ?";
   $stmt = mysqli_stmt_init($dbc);

   if (mysqli_stmt_prepare($stmt, $sql)) {
       mysqli_stmt_bind_param($stmt, 's', $usernameLogin);
       mysqli_stmt_execute($stmt);
       $result = mysqli_stmt_get_result($stmt);
       $user = mysqli_fetch_assoc($result);

       if ($user && password_verify($passLogin, $user['pass'])) {
         print 'Provjera uspješna';

           $_SESSION['username'] = $user['username'];
           $_SESSION['razina'] = $user['razina'];

           header("Location: index.php");
           exit();
       } else {
           print 'Provjera nije uspješna';
           $msg = 'Pogrešno korisničko ime ili lozinka.';
       }
   }

   mysqli_close($dbc);
   }

}

?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <script type="text/javascript" src="jquery-1.11.0.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
   <script src="js/form-validation.js"></script> 
  <title>RP Online</title>
</head>

<body>
<content>
<script type="text/javascript">

        $(function() {
            $("form[name='registracija']").validate({
                rules: {
                    ime: {
                        required: true,
                    },
                    prezime: {
                        required: true,
                    },
                    username: {
                        required: true,
                        minlength: 6,
                        maxlength: 15,
                    },
                    pass: {
                        required: true,
                        minlength: 6,
                        maxlength: 15,
                    }, 
                    passRep: {
                        equalTo: "#pass"
                    }

                },
                messages: {
                    ime: {
                        required: "Ime ne smije biti prazno",
                    },
                    prezime: {
                        required: "Prezime ne smije biti prazno",
                    },
                    username: {
                        required: "Korisnicko ime ne smije biti prazno",
                        minlength: "Korisnicko ime ne smije biti krace od 6 znakova",
                        maxlength: "Korisnicko ime ne smije biti duze od 15 znakova",
                    },
                    pass: {
                        required: "Lozinka ne smije biti prazna",
                        minlength: "Lozinka ne smije biti kraca od 6 znakova",
                        maxlength: "Lozinka ne smije biti duza od 15 znakova",
                    },
                    passRep: {
                        equalTo: "Lozinke moraju biti jednake"
                    },
                },
                highlight: function(element) {
                    $(element).next().addClass("error");
                },
                unhighlight: function(element) {
                    $(element).next().removeClass("error");
                },
                errorPlacement: function(error, element) {
                    error.addClass("error-message");
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        $(function() {
            $("form[name='prijava']").validate({
                rules: {
                    usernameLogin: {
                        required: true,
                    },
                    passLogin: {
                        required: true,
                    },
                },
                messages: {
                    usernameLogin: {
                        required: "Korisnicko ime ne smije biti prazno",
                    },
                    passLogin: {
                        required: "Lozinka ne smije biti prazna",
                    },
                },
                highlight: function(element) {
                    $(element).next().addClass("error");
                },
                unhighlight: function(element) {
                    $(element).next().removeClass("error");
                },
                errorPlacement: function(error, element) {
                    error.addClass("error-message");
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });


</script>

<div class="forms-container">
    <section class="login-body section-login">
      <h4>Registracija</h4>
        <form enctype="multipart/form-data" action="" method="POST" class="form-registration" name="registracija">
            <div class="form-item">
                <label for="title">Ime: </label>
                <div class="form-field-label form-field">
                    <input type="text" name="ime" id="ime" class="form-field-input">
                </div>
            </div>
            <div class="form-item">
                <label for="about">Prezime: </label>
                <div class="form-field-label form-field">
                    <input type="text" name="prezime" id="prezime" class="form-field-input">
                </div>
            </div>
            <div class="form-item">
            <label for="content">Korisničko ime:</label>
            <div class="form-field-label form-field">
                <input type="text" name="username" id="username" class="form-field-input">
                <div class="error-message"><?php 
                
                if(isset($msg)) {
                    echo $msg;
                }

                ?></div>
            </div>
        </div>
        <div class="form-item">
            <label for="pass">Lozinka: </label>
            <div class="form-field-label form-field">
                <input type="password" name="pass" id="pass" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <label for="pphoto">Ponovite lozinku: </label>
            <div class="form-field-label form-field">
                <input type="password" name="passRep" id="passRep" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <button type="submit" name="submit" value="Prijava" id="slanje">Registracija</button>
        </div>
        </form>

        <h4 class="margin-top">Prijava</h4>
        <form enctype="multipart/form-data" action="" method="POST" class="form-login" name="prijava">
            <div class="form-item">
            <label for="content" class="white-text">Korisničko ime:</label>
            <div class="form-field-label form-field">
                <input type="text" name="usernameLogin" id="usernameLogin" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <span id="porukaPassLogin" class="bojaPoruke"></span>
            <label for="pphotoLogin" class="white-text">Lozinka: </label>
            <div class="form-field-label form-field">
                <input type="password" name="passLogin" id="passLogin" class="form-field-input">
            </div>
        </div>
        <div class="form-item">
            <button type="submit" name="submitLogin" value="Registracija" id="login">Prijava</button>
        </div>
    </form>
</section>
</div>
    </content>
</body>

