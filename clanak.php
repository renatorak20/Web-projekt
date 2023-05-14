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

    print '<div class="article-container">';
    print '<h1 class="category">Category Name</h1>';
    print '<h2 class="title">' . $row["naslov"] . '</h2>';
    print '<p class="date">' . $row["datum"] . '</p>';
    print '<div class="image-container">';
    print '<img src="' . UPLPATH . $row["slika"] . '">';
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