<?php

define('UPLPATH', 'images/');

include('dbConnection.php');

if(isset($_POST['delete'])) { 
  $id=$_POST['id']; 
  $query = "DELETE FROM clanci WHERE id=$id "; 
  $result = mysqli_query($dbc, $query); 
  header("Location: administrator.php");
  exit();
}

if(isset($_POST['update'])) { 
  $picture = $_FILES['picture']['name']; 
  $title=$_POST['title']; 
  $about=$_POST['about']; 
  $content=$_POST['content']; 
  $category=$_POST['category']; 
  if(isset($_POST['archive'])) { 
    $archive=1; 
  } else { 
      $archive=0; 
    } 
    $target_dir = 'images/'.$picture; 
    move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir); 
    $id=$_POST['id']; 
    $query = "UPDATE clanci SET naslov='$title', kratki_sadrzaj='$about', sadrzaj='$content', slika='$picture', kategorija_id='$category', arhiva='$archive' WHERE id=$id "; 
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
    echo '<form enctype="multipart/form-data" action="" method="POST" class="form"> 
    <div class="form-item"> 
    <label for="title">Naslov vjesti:</label> 
    <div class="form-field"> 
    <input type="text" name="title" class="form-field-textual" value="'.$row['naslov'].'"> 
    </div> 
    </div> 
    <div class="form-item"> 
    <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label> 
    <div class="form-field"> 
    <textarea name="about" id="" cols="30" rows="10" class="form-field-textual">'.$row['kratki_sadrzaj'].'</textarea> 
    </div> 
    </div> 
    <div class="form-item"> 
    <label for="content">Sadržaj vijesti:</label> 
    <div class="form-field"> 
    <textarea name="content" id="" cols="30" rows="10" class="form-field-textual">'.$row['sadrzaj'].'</textarea> 
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
    <select name="category" id="" class="form-field-textual" value="'.$row['kategorija_id'].'"> 
    <option value="sport">Sport</option> 
    <option value="kultura">Kultura</option> 
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
    <button type="submit" name="update" value="Prihvati"> Izmjeni</button> 
    <button type="submit" name="delete" value="Izbriši"> Izbriši</button> 
    </div> 
    </form>'; 
}

?>

<div class="footer-parent">
    <footer>
      <?php include("footer.php"); ?>
    </footer>
  </div>
</body>
</html>