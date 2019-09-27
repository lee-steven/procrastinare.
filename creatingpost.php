<?php
require 'database.php';

session_start();

//Checking to make sure user is logged in
if(!isset($_SESSION['user'])){
    header('Location: home.php');
}

$title = $_POST['title-post'];
$link = $_POST['link-post'];
$description = $_POST['description-post'];
$time = time();

//Storing post into database
$stmt = $mysqli->prepare("insert into posts (username, title, link, description, time) values (?,?,?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('ssssi',$_SESSION['user'], $title, $link, $description, $time);

$stmt->execute();
$stmt->close();

header('Location: home.php');
exit;
?>

