<?php
require 'database.php';

session_start();

if(!isset($_SESSION['user'])){
    header('Location: home.php');
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>post on procrastinare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>
    <div class ="form-createpost">
        <h1>create a post.</h1>
        <form action="/~stevenlee/Module3/group/creatingpost.php" method="post">
            <input type="text" name="title-post" placeholder="Title" required><br>
            <input type="text" name="link-post" placeholder="Link"><br>
            <textarea name="description-post" placeholder="Description"></textarea><br>
            <input type="submit" value="create post">
        </form> 
    </div>
</body>
</html>