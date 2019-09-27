<?php

require 'database.php';
session_start();

if(isset($_SESSION['user'])){
    $currentUser = $_SESSION['user'];
}

$postid = $_GET['id'];

$stmt = $mysqli->prepare("select username, title, link, description from posts where id='{$postid}'");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$stmt->bind_result($username, $title, $link, $description);

while($stmt->fetch()){

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>
<nav class="menu">
        <div class="left-menu">
            <ul>
                <li><a href="home.php">home</a></li>
            </ul>
        </div>

        <div class="logo-menu">
            <a href="#">procrastinare.</a>
        </div>

        <div class="right-menu">
 
    </nav>
    <div class="main-viewpost">
    <?php
        printf("<h1>%s</h1><h2>post created by <span class='user-post'>%s</span></h2><h3>%s</h3><p>%s</p>",
        htmlspecialchars($title),
        htmlspecialchars($username),
        htmlspecialchars($link),
        htmlspecialchars($description)
        );
        

        if($currentUser == $username){
            ?> 
            
            <div class="editDelete-viewpost">

                <form action="/~stevenlee/Module3/group/transferuser.php?id=<?php echo $postid?>" method="post">
                    <input type="text" name="transfer-username" placeholder="Transfer to user ...">
                    <input type="submit" value="Transfer">
                </form>
                <form action="/~stevenlee/Module3/group/editstory.php?id=<?php echo $postid?>" method="post">
                    <input type="submit" value="edit">
                </form>

                <form action="/~stevenlee/Module3/group/deletestory.php?id=<?php echo $postid?>" method="post">
                    <input type="submit" value="delete">
                </form>
            </div>
            <?php
        }

        $stmt->close();
    ?>
    </div>
    <div class="comments-viewpost">
        <h1>comments</h1>
        <?php if(isset($_SESSION[user])) { ?>
        <form action="/~stevenlee/Module3/group/commenting.php" method="post">
            <textarea name="text-comments" placeholder="Comment"></textarea><br>
            <input type="hidden" name="commented-title" value="<?php echo $postid?>"/>
            <input type="submit" value="comment">
        </form>
        <?php } ?>

        <?php
            $stmt = $mysqli->prepare("select comment, username, id from comments where posts_id='{$postid}'");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->execute();
            $stmt->bind_result($comment, $username, $commentid);
            while($stmt->fetch()){
                printf("<h2>%s</h2> <br> <p>%s</p>",
                htmlspecialchars($username),
                htmlspecialchars($comment));
                
                if($currentUser == $username){
                    ?>
                    <div class="editDelete-viewcomment">
                        <form action="/~stevenlee/Module3/group/editcomment.php?id=<?php echo $commentid?>" method="post">
                            <input type="submit" value="edit">
                        </form>

                        <form action="/~stevenlee/Module3/group/deletecomment.php?id=<?php echo $commentid?>" method="post">
                            <input type="submit" value="delete">
                        </form>
                    </div>
            <?php
                }
            }
        ?>
    </div>
</body>
</html>

