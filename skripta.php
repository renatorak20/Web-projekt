<?php 
    include 'dbConnection.php'; 
    session_start();
    
    $naslov = $_POST["title"];
    $kratki_sadrzaj = $_POST["about"];
    $sadrzaj = $_POST["content"];
    $kategorija = $_POST["category"];
    $arhiva = isset($_POST["archive"]) ? 1 : 0;
    $picture = $_FILES['picture']['name']; 
    $date = date('Y-m-d');

    $sessionUsername = $_SESSION['username'];

    $target_dir = 'images/' . $picture; 
    move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir); 
    $query = "INSERT INTO clanci (naslov, kratki_sadrzaj, sadrzaj, kategorija_id, arhiva, datum, slika, autor) 
    VALUES ('$naslov', '$kratki_sadrzaj', '$sadrzaj', '$kategorija', '$arhiva', '$date', '$picture' , '$sessionUsername')"; 
    $result = mysqli_query($dbc, $query) or die('Error querying database.'); 

    $articleId = mysqli_insert_id($dbc);
    
    header("Location: clanak.php?id=$articleId");
    exit;
?>
