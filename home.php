<?php include 'dbConnection.php';
define('UPLPATH', 'images/');

$query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija_id = 0";
$result = mysqli_query($dbc, $query);
$sportArticles = mysqli_fetch_all($result, MYSQLI_ASSOC);

$query = "SELECT * FROM clanci WHERE arhiva = 0 AND kategorija_id = 1";
$result = mysqli_query($dbc, $query);
$politicsArticles = mysqli_fetch_all($result, MYSQLI_ASSOC);

session_start();

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  print 'Prijavljeni ste:' . $username;
} else {
  print 'Niste prijavljeni:';
}
?>

<div class="category-container">
  <div class="category-group">
    <section class="category">
    <a href="index.php?menu=2" class="category-title">Sport</a>
    </section>

    <?php foreach ($sportArticles as $article) : ?>
      <article>
        <a href="clanak.php?id=<?php echo $article['id']; ?>">
        <div class="article">
          <div class="sport_img">
            <img src="<?php echo UPLPATH . $article['slika']; ?>">
          </div>
          <div class="media_body">
            <h4 class="title">
                <?php echo $article['naslov']; ?>
            </h4>
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
    <a href="index.php?menu=3" class="category-title">Politik</a>
    </section>

    <?php foreach ($politicsArticles as $article) : ?>
      <article>
      <a href="clanak.php?id=<?php echo $article['id']; ?>">
        <div class="article">
          <div class="sport_img">
            <img src="<?php echo UPLPATH . $article['slika']; ?>">
          </div>
          <div class="media_body">
            <h4 class="title">
                <?php echo $article['naslov']; ?>
            </h4>
            <p class="description"><?php echo $article['kratki_sadrzaj']; ?></p>
          </div>
        </div>
        </a>
      </article>
    <?php endforeach; ?>
</div>
</div>