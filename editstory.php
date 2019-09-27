<?php
require 'database.php';

session_start();

if(!isset($_SESSION['user'])){
    header('Location: home.php');
}

$postid = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>edit on procrastinare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>
    <div class ="form-createpost">
        <h1>edit post.</h1>

        <?php
            //select post to be edited
            $stmt = $mysqli->prepare("select username, title, link, description from posts where id='{$postid}'");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            
            $stmt->execute();
            $stmt->bind_result($username, $title, $link, $description);
            
            while($stmt->fetch()){
 
                if($_SESSION['user'] != $username){
                    echo "You don't have permissions to edit this post"; 
                    exit;            
                } 
                ?>  
                <form action="/~stevenlee/Module3/group/editingstory.php?id=<?php echo $postid; ?>" method="post">
                    <input type="text" name="title-post" placeholder="Title" value="<?php echo $title; ?>" required><br>
                    <input type="text" name="link-post" placeholder="Link" value="<?php echo $link; ?>"><br>
                    <textarea name="description-post" placeholder="Description"><?php echo $description; ?></textarea><br>
                    <input type="submit" value="edit post">
                 </form>
                <?php
                
            }?>
  
    </div>
</body>
</html>