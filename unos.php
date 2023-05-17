<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Unos vijesti ili proizvoda</title>
  <link rel="stylesheet" type="text/css" href="newStyle.css">
  <script type="text/javascript" src="jquery-1.11.0.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

  <script type="text/javascript">
    function slanje() {

      var slanjeForme = true;

      var poljeTitle = document.getElementById("title");
      var title = document.getElementById("title").value;

      if (title.length < 5 || title.length > 30) {
        slanjeForme = false;
        poljeTitle.style.border="1px dashed red";
        document.getElementById("porukaTitle").innerHTML="Naslov vjesti mora imati između 5 i 30 znakova!<br>";
      } else {
        poljeTitle.style.border="1px solid green";
        document.getElementById("porukaTitle").innerHTML="";
      }

      var poljeAbout = document.getElementById("about");
      var about = document.getElementById("about").value;
      if (about.length < 10 || about.length > 100) {
        slanjeForme = false;
        poljeAbout.style.border="1px dashed red";
        document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
        } else {
        poljeAbout.style.border="1px solid green";
        document.getElementById("porukaAbout").innerHTML="";
      }

      var poljeContent = document.getElementById("content");
      var content = document.getElementById("content").value;
      if (content.length == 0) {
        slanjeForme = false;
        poljeContent.style.border="1px dashed red";
        document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";
      } else {
        poljeContent.style.border="1px solid green";
        document.getElementById("porukaContent").innerHTML="";
      }

      var poljeSlika = document.getElementById("picture");
      var pphoto = document.getElementById("picture").value;
      if (pphoto.length == 0) {
        slanjeForme = false;
        poljeSlika.style.border="1px dashed red";
        document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
      } else {
        poljeSlika.style.border="1px solid green";
        document.getElementById("porukaSlika").innerHTML="";
      }

      var poljeCategory = document.getElementById("category");
      if(document.getElementById("category").selectedIndex == 0) {
        slanjeForme = false;
        poljeCategory.style.border="1px dashed red";
        document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
      } else {
        poljeCategory.style.border="1px solid green";
        document.getElementById("porukaKategorija").innerHTML="";
      }

      if (slanjeForme != true) {
        event.preventDefault();
      } else {
        include 'dbConnection.php'; 
        $naslov = $_POST["title"];
        $kratki_sadrzaj = $_POST["about"];
        $sadrzaj = $_POST["content"];
        $kategorija = $_POST["category"];
        $arhiva = isset($_POST["archive"]) ? 1 : 0;
        $picture = $_FILES['picture']['name']; 
        $date = date('Y-m-d');

        $target_dir = 'images/' . $picture; 
        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir); 
        $query = "INSERT INTO clanci (naslov, kratki_sadrzaj, sadrzaj, kategorija_id, arhiva, datum, slika) 
        VALUES ('$naslov', '$kratki_sadrzaj', '$sadrzaj', '$kategorija', '$arhiva', '$date', '$picture')"; 
        $result = mysqli_query($dbc, $query) or die('Error querying database.'); 

        $articleId = mysqli_insert_id($dbc);
        
        header("Location: clanak.php?id=$articleId");
        exit;
      }
}

    </script>
  <main>
    <h1 class="naslov">Unos vijesti</h1>
    <form action="" method="POST" enctype="multipart/form-data"> 
      <div class="form-item"> 
        <span id="porukaTitle" class="bojaPoruke"></span>
        <label for="title">Naslov vijesti</label> 
        <div class="form-field"> 
          <input type="text" name="title" class="form-field-textual"> 
        </div> 
      </div> 
      <div class="form-item"> 
        <span id="porukaAbout" class="bojaPoruke"></span>
        <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label> 
        <div class="form-field"> 
          <textarea name="about" id="" cols="30" rows="10" class="form-field-textual"></textarea> 
        </div> 
      </div> 
      <div class="form-item"> 
        <span id="porukaContent" class="bojaPoruke"></span>
        <label for="content">Sadržaj vijesti</label> 
        <div class="form-field"> 
          <textarea name="content" id="" cols="30" rows="10" class="form-field-textual"></textarea> 
        </div> 
      </div> 
      <div class="form-item"> 
        <span id="porukaSlika" class="bojaPoruke"></span>
        <label for="pphoto">Slika: </label> 
        <div class="form-field"> 
          <input type="file" accept="image/jpg,image/gif,image/png,image/jpeg" class="input-text" name="picture"/> 
        </div> 
      </div> 
      <div class="form-item"> 
        <span id="porukaKategorija" class="bojaPoruke"></span>
        <label for="category">Kategorija vijesti</label>
      <div class="form-field"> 
        <select name="category" id="" class="form-field-textual"> 
          <option value="0">Sport</option> 
          <option value="1">Politik</option> 
        </select> 
      </div> 
    </div> 
      <div class="form-item"> 
      <label>Spremiti u arhivu: 
      <div class="form-field"> 
        <input type="checkbox" name="archive"> 
      </div> 
    </label> 
    </div> 
    <div class="form-item"> 
      <button type="reset" value="Poništi">Poništi</button> 
      <button type="submit" value="Prihvati" id="slanje" onclick="slanje()">Prihvati</button> 
    </div> 
    </form>
  </main>


</body>
</html>
