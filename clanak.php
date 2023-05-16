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

include('dbConnection.php');
define('UPLPATH', 'images/');

    if(isset($_GET['id'])) { 
        $id = (int)$_GET['id']; 
    }

    $query = "SELECT * FROM clanci WHERE id = $id"; 
    $result = mysqli_query($dbc, $query); 
    $row = mysqli_fetch_array($result);

    if($row["kategorija_id"] == 0) {
      $kategorija = 2;
      $kat_ime = "Sport";
    } else {
      $kategorija = 3;
      $kat_ime = "Politik";
    }

    $formatiran_datum = date('d. F Y', strtotime($row["datum"]));


    print '<div class="article-container">';
    print '<section class="category" style="margin-top:0px;">';
    print '<a class="category-title" href="index.php?menu=' . $kategorija . '">' . $kat_ime .'</a>';
    print '</section>';
    print '<h2 class="title-detail">' . $row["naslov"] . '</h2>';
    print '<p class="date-detail">' . $formatiran_datum . '</p>';
    print '<div>';
    print '<img class="image-container-detail" src="' . UPLPATH . $row["slika"] . '">';
    print '</div>';
    print '<p class="brief-description">' . $row["kratki_sadrzaj"] . '</p>';
    print '<p class="long-description">' . $row["sadrzaj"] . '</p>';
    print '</div>';
?>

<div class="footer-parent">
    <footer>
      <?php include("footer.php"); ?>
    </footer>
  </div>
</body>
</html>