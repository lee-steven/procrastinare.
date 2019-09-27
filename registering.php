<?php
require 'database.php';

session_start();

// if(!hash_equals($_SESSION['token'], $_POST['token'])){
//     die("Request forgery detected");
// }

$createdUsername = $_POST['createUsername'];
$createdPassword = $_POST['createPassword'];
$validatedCreatedPassword = $_POST['validateCreatePassword'];

if(!isset($createdUsername) && !isset($createdPassword) && !isset($validatedCreatedPassword)){
    header('Location: register.php?failure=3');
    exit;
}

//Checking if username is already in database
$stmt = $mysqli->prepare("select username from users");
if(!stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->execute();
$stmt->bind_result($retrievedUsername);

while($stmt->fetch()){
    if(htmlspecialchars($retrievedUsername) == htmlspecialchars($createdUsername)){
        header('Location: register.php?failure=1');
        exit;
    }
}
$stmt->close();

//Check to see if the two passwords match
if(htmlspecialchars($createdPassword) != htmlspecialchars($validatedCreatedPassword)){
    header('Location: register.php?failure=2');
    exit;
}

//Adding username to database
$stmt = $mysqli->prepare("insert into users (username,password) values (?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$hashedPassword = password_hash(htmlspecialchars($createdPassword), PASSWORD_BCRYPT);

$stmt->bind_param('ss', $createdUsername, $hashedPassword);
$stmt->execute();
$stmt->close();

header('Location: home.php');
exit;
?>