<?php

session_start();

$admin = false;
$sessionUsername = "";
$sessionRazina = "";
$ulogiran = true;

if(isset($_SESSION['username']) && isset($_SESSION['razina'])) {
  $sessionUsername = $_SESSION['username'];
  $sessionRazina = $_SESSION['razina'];

  if ($sessionRazina == 1) {
    $admin = true;
  }
} else {
  $ulogiran = false;
}
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
            </li>';
            
      if($admin == true) {
        echo '
        <li>
        <a href="index.php?menu=4">ADMINISTRACIJA</a>
      </li>
        <li>
        <a href="administrator.php">ADMINISTRATOR</a>
      </li>';
      }
      if(isset($_SESSION['username'])) {
        echo '<li class="username logout">' . $sessionUsername . '</li>';
        echo '<li>
            <a href="logout.php">Log out</a>
       </li>';
      } else {
        echo '
        <li>
        <a href="index.php?menu=4">LOGIN</a>
      </li>';
      }

echo '</ul>';
?>