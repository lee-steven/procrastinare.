<?php
require 'database.php';

session_start();

if(!isset($_SESSION['user'])){
    header('Location: home.php');
}


$postid = $_GET['id'];

$title = $_POST['title-post'];
$link = $_POST['link-post'];
$description = $_POST['description-post'];

//selecting corresponding post to edit
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

//update post to edited details
$stmt = $mysqli->prepare("update posts set title=?, link=?, description=? where id=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('sssi', $title, $link, $description, $postid);
$stmt->execute();
$stmt->close();

header('Location: viewpost.php?id='.$postid);
exit;
?>

