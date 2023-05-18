<?php

define('UPLPATH', 'images/');

include('dbConnection.php');

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

if(isset($_POST['delete'])) { 
  $id=$_POST['id']; 
  $query = "DELETE FROM clanci WHERE id=$id "; 
  $result = mysqli_query($dbc, $query); 
  header("Location: administrator.php");
  exit();
}

if (isset($_POST['update'])) { 
  $id = $_POST['id'];
  $title = $_POST['title'];
  $about = $_POST['about'];
  $content = $_POST['content'];
  $category = $_POST['category'];
  if (isset($_POST['archive'])) { 
    $archive = 1; 
  } else { 
    $archive = 0; 
  }

  if ($_FILES['picture']['name'] != '') {
    $picture = $_FILES['picture']['name'];
    $target_dir = 'images/' . $picture;
    move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir);
  } else {
    $query = "SELECT slika FROM clanci WHERE id = $id";
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_assoc($result);
    $picture = $row['slika'];
  }

  $query = "UPDATE clanci SET naslov='$title', kratki_sadrzaj='$about', sadrzaj='$content', slika='$picture', kategorija_id='$category', arhiva='$archive' WHERE id=$id";
  $result = mysqli_query($dbc, $query);
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
  <div class="nav-parent">
    <nav>
      <?php include("header.php"); ?>
    </nav>
  </div>


<?php

$query = "SELECT * FROM clanci"; 
$result = mysqli_query($dbc, $query); 
while($row = mysqli_fetch_array($result)) { 
  echo '<form enctype="multipart/form-data" action="" method="POST" class="form form-edit" name="edit"> 
  <div class="form-item"> 
  <div class="form-field">
  <label for="title">Naslov vjesti:</label> 
  <input type="text" name="title" class="form-field-textual edit-input" value="'.$row['naslov'].'"> 
  </div> 
  </div> 
  <div class="form-item">
  <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label> 
  <div class="form-field"> 
  <textarea name="about" id="kratki_sadrzaj" cols="30" rows="10" class="form-field-textual">'.$row['kratki_sadrzaj'].'</textarea> 
  </div> 
  </div> 
  <div class="form-item">
  <label for="content">Sadržaj vijesti:</label> 
  <div class="form-field"> 
  <textarea name="content" id="sadrzaj" cols="30" rows="10" class="form-field-textual">'.$row['sadrzaj'].'</textarea> 
  </div> 
  </div> 
  <div class="form-item"> 
  <label for="pphoto">Slika:</label> 
  <div class="form-field">
  <input type="file" class="input-text" id="picture" value="'.$row['slika'].'" name="picture"/> 
  <br>
  <img src="' . UPLPATH . $row['slika'] . '" width=100px>
  </div> 
  </div> 
  <div class="form-item"> 
  <label for="category">Kategorija vijesti:</label> 
  <div class="form-field"> 
  <select name="category" id="" class="form-field-textual"> 
  <option value="0"'; if ($row['kategorija_id'] == 0) echo ' selected="selected"'; echo '>Sport</option> 
  <option value="1"'; if ($row['kategorija_id'] == 1) echo ' selected="selected"'; echo '>Politik</option> 
  </select> 
  </div> 
  </div> 
  <div class="form-item"> 
  <label>Spremiti u arhivu: 
  <div class="form-checkbox">';
    if($row['arhiva'] == 0) { 
        echo '<input type="checkbox" name="archive" id="archive"/> Arhiviraj?'; 
    } else { 
        echo '<input type="checkbox" name="archive" id="archive" checked/> Arhiviraj?'; 
    } echo '
    </div> 
    </label> 
    </div> 
    </div> 
    <div class="form-item"> 
    <input type="hidden" name="id" class="form-field-textual" value="'.$row['id'].'"> 
    <button type="reset" value="Poništi">Poništi</button> 
    <button type="submit" name="update" value="Prihvati" id="izmjeni">Izmjeni</button> 
    <button type="submit" name="delete" value="Izbriši">Izbriši</button> 
    </div> 
    </form>'; 
}

?>

<script>
        $(function() {
            $("form[name='edit']").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 5,
                        maxlength: 30,
                    },
                    about: {
                        required: true,
                        minlength: 10,
                        maxlength: 50,
                    },
                    content: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: "Naslov ne smije biti prazan",
                        minlength: "Naslov treba imati više od 6 znakova",
                        maxlength: "Naslov treba imati manje od 30 znakova",
                    },
                    about: {
                        required: "Potrebno je upisati kratki sadrzaj",
                        minlength: "Kratki sadrzaj ne smije biti kraci od 10 znakova",
                        maxLength: "Kratki sadrzaj ne smije biti duzi od 50 znakova",
                    },
                    content: {
                        required: "Potrebno je upisati sadrzaj",
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

<div class="footer-parent">
    <footer>
      <?php include("footer.php"); ?>
    </footer>
  </div>
</body>
</html>