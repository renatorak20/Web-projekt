<?php

    if(isset($_POST['submit'])){
        login();
    } 

function login(){
    include ("dbconn.php");

    $query  = "SELECT * FROM users";
    $query .= " WHERE username='" .  $_POST['username'] . "'";
    $result = @mysqli_query($db, $query);
    $row = @mysqli_fetch_array($result);
    
    if (password_verify($_POST['password'], $row['password'])) {
        
        $_SESSION['users']['valid'] = 'true';
        $_SESSION['users']['id'] = $row['id'];
        $_SESSION['users']['firstname'] = $row['firstname'];
        $_SESSION['users']['lastname'] = $row['lastname'];
      
        $_SESSION['message'] = '<p>Dobrodošao/la, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
        header( "refresh:0;url=index.php" );

    }

    else {
        unset($_SESSION['users']);
        $_SESSION['message'] = '<p>Pogrešna lozinka ili username!</p>';
        message(2, $_SESSION['message']);
        unset($_SESSION['message']);
    }

}

?>