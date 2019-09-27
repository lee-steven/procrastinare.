<?php
require 'database.php';
session_start();

if(!isset($_SESSION['user'])){
    header('Location: home.php');
}


$comment = $_POST['text-comments'];
$title = $_POST['commented-title'];

//Storing comments by the username and posts_id
$stmt = $mysqli->prepare("insert into comments (username, comment,posts_id) values (?,?,?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('ssi', $_SESSION['user'], $comment, $title);
$stmt->execute();
$stmt->close();

header('Location: viewpost.php?id='.$title);
exit;
?>