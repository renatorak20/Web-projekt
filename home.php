<?php include 'dbConnection.php'; 
define('UPLPATH', 'images/'); ?>

<?php 
      $query = "SELECT * FROM clanci WHERE arhiva" . "= 0"; 
      $result = mysqli_query($dbc, $query); 
      $i=0; 
      while ($row = mysqli_fetch_array($result)) {
            echo '<article>';
            echo '<div class="article">';
            echo '<div class="sport_img">';
            echo '<img src="' . UPLPATH . $row['slika'] . '">';
            echo '</div>';
            echo '<div class="media_body">';
            echo '<h4 class="title">';
            echo '<a href="clanak.php?id=' . $row['id'] . '">';
            echo $row['naslov'];
            echo '</a></h4>';
            echo '<p class="description">';
            echo $row['kratki_sadrzaj'];
            echo '</p>';
            echo '</div>';
            echo '</div>';
            echo '</article>';
          }
?>