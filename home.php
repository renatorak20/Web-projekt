<?php include 'dbConnection.php';
define('UPLPATH', 'images/');

$query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija_id = 0";
$result = mysqli_query($dbc, $query);
$sportArticles = mysqli_fetch_all($result, MYSQLI_ASSOC);

$query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija_id = 1";
$result = mysqli_query($dbc, $query);
$politicsArticles = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="category-container">
  <div class="category-group">
    <section class="category">
      <a href="https://www.example.com" target="_blank" class="category-title">Sport</a>
    </section>

    <?php foreach ($sportArticles as $article) : ?>
      <article>
        <div class="article">
          <div class="sport_img">
            <img src="<?php echo UPLPATH . $article['slika']; ?>">
          </div>
          <div class="media_body">
            <h4 class="title">
              <a href="clanak.php?id=<?php echo $article['id']; ?>">
                <?php echo $article['naslov']; ?>
              </a>
            </h4>
            <p class="description"><?php echo $article['kratki_sadrzaj']; ?></p>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
</div>
<div class="category-group">
    <section class="category">
      <a href="https://www.example.com" target="_blank" class="category-title">Politics</a>
    </section>

    <?php foreach ($politicsArticles as $article) : ?>
      <article>
        <div class="article">
          <div class="sport_img">
            <img src="<?php echo UPLPATH . $article['slika']; ?>">
          </div>
          <div class="media_body">
            <h4 class="title">
              <a href="clanak.php?id=<?php echo $article['id']; ?>">
                <?php echo $article['naslov']; ?>
              </a>
            </h4>
            <p class="description"><?php echo $article['kratki_sadrzaj']; ?></p>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</div>