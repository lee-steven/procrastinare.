<?php
require 'database.php';

session_start();

if(!isset($_SESSION['user'])){
    header('Location: home.php');
}


$postid = $_GET['id'];

$transferuser = $_POST['transfer-username'];

$stmt = $mysqli->prepare("select username from posts where id='{$postid}'");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$stmt->bind_result($username);

while($stmt->fetch()){

    if($_SESSION['user'] != $username){
        echo "You don't have permissions to edit this post"; 
        exit;            
    }

} 
$stmt->close();


$stmt = $mysqli->prepare("select username from users where username='{$transferuser}'");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$stmt->bind_result($username_useless);
$valid = false;
while($stmt->fetch()){          
    $valid = true;
} 

if (!$valid) {
    echo "That user does not exist."; 
    exit; 
}

$stmt->close();


$stmt = $mysqli->prepare("update posts set username=? where id=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('si', $transferuser, $postid);
$stmt->execute();
$stmt->close();

header('Location: viewpost.php?id='.$postid);
exit;
?>

