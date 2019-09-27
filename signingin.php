<?php
require 'database.php';

session_start();
// if(!hash_equals($_SESSION['token'], $_POST['token'])){
//     die("Request forgery detected");
// }
$signInUsername = $_POST['signInUsername'];
$signInPassword = $_POST['signInPassword'];

//Check if username and password match in database
$stmt = $mysqli->prepare("select username,password from users");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->execute();
$stmt->bind_result($retrievedUsername, $retrievedPassword);

while($stmt->fetch()){
    if(htmlspecialchars($retrievedUsername) == htmlspecialchars($signInUsername)){
        if(password_verify(htmlspecialchars($signInPassword), $retrievedPassword)){
            //Login successful
            $_SESSION['user'] = $signInUsername;
            // $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
            header('Location: home.php');
            exit;
        }
    }
}
$stmt->close();

//If not redirect back to signin.php w/ error message
// header('Location: signin.php?failure=1');
// exit;

?>