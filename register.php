<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>register to procrastinate.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>
<body>
    <div class="form-register">
        <h1>procrastinare.</h1>
        <p>
        <?php
            //Error messages
            if(isset($_GET['failure']) && $_GET['failure'] == 1){
                echo "This username is already taken!";
            } elseif (isset($_GET['failure']) && $_GET['failure'] == 2){
                echo "The passwords do not match!";
            } elseif (isset($_GET['failure']) && $_GET['failure'] == 3){
                echo "Please enter all fields!";
            }
        ?>
        </p>
        <form action="registering.php" method="post">
            <input type="text" name="createUsername" placeholder="Username" required><br>
            <input type="password" name="createPassword" placeholder="Password" required><br>
            <input type="password" name="validateCreatePassword" placeholder="Confirm Password" required><br>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
            <a href="/~stevenlee/Module3/group/signin.php">sign in</a>
            <input type="submit" value="Create Account"/>
        </form>
    </div>  
</body>
</html>