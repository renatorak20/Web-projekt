<?php include 'dbConnection.php';
define('UPLPATH', 'images/');

$query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija_id = 0";
$result = mysqli_query($dbc, $query);
$sportArticles = mysqli_fetch_all($result, MYSQLI_ASSOC);

$query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija_id = 1";
$result = mysqli_query($dbc, $query);
$politicsArticles = mysqli_fetch_all($result, MYSQLI_ASSOC);

if(!isset($_SESSION)) {
  session_start();
}
?>

<div class="category-container">
  <div class="category-group">
    <section class="category">
    <a href="kategorija.php?kategorija=0" class="category-title">Sport</a>
    </section>

    <?php foreach ($sportArticles as $article) : ?>
      <article>
        <a href="clanak.php?id=<?php echo $article['id']; ?>">
        <div class="article">
          <div class="sport_img">
            <img src="<?php echo UPLPATH . $article['slika']; ?>">
          </div>
          <div class="media_body">
            <h1 class="title">
                <?php echo $article['naslov']; ?>
            </h1>
            <p class="description"><?php echo $article['kratki_sadrzaj']; ?></p>
          </div>
        </div>
              </a>
      </article>
    <?php endforeach; ?>
</div>
</div>

<div class="category-container">
  <div class="category-group">
    <section class="category">
    <a href="kategorija.php?kategorija=1" class="category-title">Politik</a>
    </section>

    <?php foreach ($politicsArticles as $article) : ?>
      <article>
      <a href="clanak.php?id=<?php echo $article['id']; ?>">
        <div class="article">
          <div class="sport_img">
            <img src="<?php echo UPLPATH . $article['slika']; ?>">
          </div>
          <div class="media_body">
            <h1 class="title">
                <?php echo $article['naslov']; ?>
            </h1>
            <p class="description"><?php echo $article['kratki_sadrzaj']; ?></p>
          </div>
        </div>
        </a>
      </article>
    <?php endforeach; ?>
</div>
</div>