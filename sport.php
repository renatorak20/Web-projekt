<?php include 'dbConnection.php'; 
define('UPLPATH', 'images/'); ?>

<?php 
      $query = "SELECT * FROM clanci WHERE arhiva" . "= 0" . " AND kategorija_id" . "= 0"; 
      $result = mysqli_query($dbc, $query); 
      $i=0; 
      echo '<div class="category-container">';
      echo '<div class="category-group">';
      echo '<section class="category">
            <a href="index.php?menu=2" class="category-title">Sport</a>
            </section>';
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
?>