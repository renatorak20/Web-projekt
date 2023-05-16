<?php

session_start();

$admin = false;
$sessionUsername = "";
$sessionRazina = "";

if(isset($_SESSION['username']) && isset($_SESSION['razina'])) {
  $sessionUsername = $_SESSION['username'];
  $sessionRazina = $_SESSION['razina'];

  if ($sessionRazina == 1) {
    $admin = true;
  }
}

echo '<script>console.log('.json_encode($sessionUsername).')</script>';
echo '<script>console.log('.json_encode($sessionRazina).')</script>';

 echo '<img src="images/RP-Online-Logo.svg" class="logo"/>
        
        <ul>
          <li>
            <a href="index.php?menu=1">HOME</a>
          </li>
           <li>
             <a href="kategorija.php?kategorija=0">SPORT</a>
            </li>
           <li>
             <a href="kategorija.php?kategorija=1">POLITIK</a>
            </li>
            <li>
              <a href="index.php?menu=4">ADMINISTRACIJA</a>
            </li>';
            
      if($admin == true) {
        echo '<li>
        <a href="administrator.php">ADMINISTRATOR</a>
      </li>';
      }

echo '</ul>';
?>