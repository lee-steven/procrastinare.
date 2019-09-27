<?php

require 'database.php';
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>procrastinare | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>
    <nav class="menu">
        <div class="left-menu">
            <ul>
                <li><a href="#">home</a></li>
            </ul>
        </div>

        <div class="logo-menu">
            <a href="#">procrastinare.</a>
        </div>

        <div class="right-menu">
            <ul>
                <?php if(isset($_SESSION[user])) { ?>
                    <!--    WARNING: DON'T FORGET TO ADD LINKS! -->
                    <li class="createPostLink"><a href="/~stevenlee/Module3/group/createpost.php">create post</a></li>
                    <li class="profileLink"><a href="#"><?php echo htmlspecialchars($_SESSION[user])?></a></li>
                    <li class="logOutLink"><a href="/~stevenlee/Module3/group/logout.php">log out</a></li>
                <?php } else { ?>
                    <li class="registerLink"><a href="/~stevenlee/Module3/group/register.php">register</a></li>
                    <li class="signinLink"><a href="/~stevenlee/Module3/group/signin.php">sign in</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <main class="posts-home">
        <?php
        //Loading in posts
            $stmt = $mysqli->prepare("select username, title, id, time from posts");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->execute();
            $stmt->bind_result($username, $title, $id, $time);

            echo "<ul>\n";
            while($stmt->fetch()){
                printf("<li><a href='viewpost.php?id=%d'>%s</a> <br> <span class='user-posts'>post created by %s</span> <br> <p>%s</p></li>",
                htmlspecialchars($id),
                htmlspecialchars($title),
                htmlspecialchars($username),
                htmlspecialchars(date('F jS, Y h:i A', $time))
                );
            }
            echo "</ul>\n";
            $stmt->close();
        ?>
    </main>
</body>
</html>