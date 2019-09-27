<?php
require 'database.php';

session_start();

if(!isset($_SESSION['user'])){
    header('Location: home.php');
    exit;
}

$commentid = $_GET['id'];

//Finding the correct username with corresponding comment
$stmt = $mysqli->prepare("select username,posts_id from comments where id='{$commentid}'");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$stmt->bind_result($username, $postid);

while($stmt->fetch()){
    //Making sure user is correct user and can delete post
    if($_SESSION['user'] != $username){
        echo "You don't have permissions to delete this post"; 
        exit;            
    }

} 
$stmt->close();

$stmt2 = $mysqli->prepare("delete from comments where id='{$commentid}'");
if(!$stmt2){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt2->execute();
$stmt2->close();

header('Location: viewpost.php?id='.$postid);
exit;
?>