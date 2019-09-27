<?php
    session_start();
    // $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>sign in to procrastinate.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>
    <div class="form-signin">
        <h1>procrastinare.</h1>
        <p>
        <?php
            if(isset($_GET['failure']) && $_GET['failure'] == 1){
                echo "Incorrect username or password";
            }
        ?>
        </p>
        <form action="signingin.php" method="post">
            <input type="text" name="signInUsername" placeholder="Username" required><br>
            <input type="password" name="signInPassword" placeholder="Password" required><br>
            <!-- <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" /> -->
            <a href="/~stevenlee/Module3/group/register.php">register</a>
            <input type="submit" value="Sign In"/>
        </form>
    </div>  


</body>
</html>