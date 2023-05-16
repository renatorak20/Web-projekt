<?php 
include 'dbConnection.php'; 
define('UPLPATH', 'images/'); 

if(isset($_GET['kategorija'])) { 
    $kategorija_id = (int)$_GET['kategorija']; 
}

if($kategorija_id == 0) {
    $kategorija_naziv = "Sport";
} else {
    $kategorija_naziv = "Politik";
}

$query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija_id = " . $kategorija_id; 
$result = mysqli_query($dbc, $query); 


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

echo '<div class="category-container">';
echo '<div class="category-group">';
echo '<section class="category">';
echo '<a href="index.php?menu=3" class="category-title">' . $kategorija_naziv .'</a>';
echo '</section>';

while ($row = mysqli_fetch_array($result)) {
  echo '<article>';
  echo '<a href="clanak.php?id=' . $row['id'] . '">';
  echo '<div class="article">';
  echo '<div class="sport_img">';
  echo '<img src="' . UPLPATH . $row['slika'] . '">';
  echo '</div>';
  echo '<div class="media_body">';
  echo '<h4 class="title">';
  echo $row['naslov'];
  echo '</h4>';
  echo '<p class="description">';
  echo $row['kratki_sadrzaj'];
  echo '</p>';
  echo '</div>';
  echo '</div>';
  echo '</a>';
  echo '</article>';
}

echo '</div>';
echo '</div>';

exit;

    ?>

  <div class="footer-parent">
    <footer>
      <?php include("footer.php"); ?>
    </footer>
  </div>
</body>
</html>