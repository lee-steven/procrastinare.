<?php
require 'database.php';

session_start();

if(!isset($_SESSION['user'])){
    header('Location: home.php');
}


$commentid = $_GET['id'];


$comment = $_POST['comment-post'];

//selecting corresponding comment to edit
$stmt = $mysqli->prepare("select username, posts_id from comments where id='{$commentid}'");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$stmt->bind_result($username, $id);

while($stmt->fetch()){

    if($_SESSION['user'] != $username){
        echo "You don't have permissions to edit this post"; 
        exit;            
    }

} 
$stmt->close();


$stmt = $mysqli->prepare("update comments set comment=? where id=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('si', $comment, $commentid);
$stmt->execute();
$stmt->close();

header('Location: viewpost.php?id='.$id);
exit;
?>

