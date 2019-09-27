<?php
require 'database.php';

session_start();

if(!isset($_SESSION['user'])){
    header('Location: home.php');
    exit;
}

$postid = $_GET['id'];

//Finding corresponding post 
$stmt = $mysqli->prepare("select username, title, link, description from posts where id='{$postid}'");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$stmt->bind_result($username, $title, $link, $description);

while($stmt->fetch()){

    //Checking to make sure it is correct user
    if($_SESSION['user'] != $username){
        echo "You don't have permissions to edit this post"; 
        exit;            
    }

} 
$stmt->close();

$stmt2 = $mysqli->prepare("delete from comments where posts_id='{$postid}'");
if(!$stmt2){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt2->execute();
$stmt2->close();

$stmt2 = $mysqli->prepare("delete from posts where id='{$postid}'");
if(!$stmt2){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt2->execute();
$stmt2->close();
header('Location: home.php');
exit;
?>