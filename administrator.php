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
  echo '<form enctype="multipart/form-data" action="" method="POST" class="form form-edit"> 
  <div class="form-item"> 
  <label for="title">Naslov vjesti:</label> 
  <div class="form-field"> 
  <span id="porukaNaslov" class="bojaPoruke"></span>
  <input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'"> 
  </div> 
  </div> 
  <div class="form-item"> 
  <span id="porukaKratki" class="bojaPoruke"></span>
  <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label> 
  <div class="form-field"> 
  <textarea name="about" id="kratki_sadrzaj" cols="30" rows="10" class="form-field-textual">'.$row['kratki_sadrzaj'].'</textarea> 
  </div> 
  </div> 
  <div class="form-item"> 
  <span id="porukaAbout" class="bojaPoruke"></span>
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
  <div class="form-field">';
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

<script type="text/javascript">
    document.getElementById("izmjeni").onclick = function(event) {

    var slanjeForme = true;

    var poljeTitle = document.getElementById("title");
    var title = document.getElementById("title").value;

    if (title.length < 5 || title.length > 30) {
      slanjeForme = false;
      poljeTitle.style.border="1px dashed red";
      document.getElementById("porukaNaslov").innerHTML="Naslov vjesti mora imati između 5 i 30 znakova!<br>";
    } else {
      poljeTitle.style.border="1px solid green";
      document.getElementById("porukaNaslov").innerHTML="";
    }

    var poljeKratkiSadrzaj = document.getElementById("kratki_sadrzaj");
    var kratkiSadrzaj = document.getElementById("kratki_sadrzaj").value;
    if (about.length < 10 || about.length > 100) {
      slanjeForme = false;
      poljeKratkiSadrzaj.style.border="1px dashed red";
      document.getElementById("porukaKratki").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
      } else {
      poljeKratkiSadrzaj.style.border="1px solid green";
      document.getElementById("porukaKratki").innerHTML="";
    }

    var poljeSadrzaj = document.getElementById("sadrzaj");
    var sadrzaj = document.getElementById("sadrzaj").value;
    if (content.length == 0) {
      slanjeForme = false;
      poljeSadrzaj.style.border="1px dashed red";
      document.getElementById("porukaSadrzaj").innerHTML="Sadržaj mora biti unesen!<br>";
    } else {
      poljeSadrzaj.style.border="1px solid green";
      document.getElementById("porukaSadrzaj").innerHTML="";
    }

    if (slanjeForme != true) {
      event.preventDefault();
    }};
    </script>

<div class="footer-parent">
    <footer>
      <?php include("footer.php"); ?>
    </footer>
  </div>
</body>
</html>