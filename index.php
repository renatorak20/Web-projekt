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

  if(isset($_GET['menu'])) { 
    $menu   = (int)$_GET['menu']; 
  }

  if (!isset($menu) || $menu == 1) {
    include("home.php");
  } else if ($menu == 2) {
    include("sport.php");
  } else if ($menu == 3) {
    include("politik.php");
  } else if ($menu == 4) {
    include("administracija.php");
  }
  ?>

  <div class="footer-parent">
    <footer>
      <?php include("footer.php"); ?>
    </footer>
  </div>
</body>
</html>
