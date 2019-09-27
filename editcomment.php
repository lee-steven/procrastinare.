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
        <h1>edit comment.</h1>

        <?php
            //selecting corresponding comment
            $stmt = $mysqli->prepare("select username, comment from comments where id='{$postid}'");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            
            $stmt->execute();
            $stmt->bind_result($username, $comment);
            
            while($stmt->fetch()){
 
                if($_SESSION['user'] != $username){
                    echo "You don't have permissions to edit this post"; 
                    exit;            
                } 
                ?>  
                <form action="/~stevenlee/Module3/group/editingcomment.php?id=<?php echo $postid; ?>" method="post">
                    <textarea name="comment-post" placeholder="Description"><?php echo $comment; ?></textarea><br>
                    <input type="submit" value="edit comment">
                 </form>
                <?php
                
            }?>
  
    </div>
</body>
</html>