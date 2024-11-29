<?php
session_start();
unset($_SESSION['user']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>

    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<main>
    <div class="form-cont">
        <form action="../action/loginAction.php" method="post">
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Username or Email" >
            <?php
            if ($_SESSION["errors"]["login"]["username"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["login"]["username"]?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION["errors"]["login"]["emailuser"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["login"]["emailuser"]?></span>
                <?php
            }
            ?>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"  >
            <?php
            if ($_SESSION["errors"]["login"]["password"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["login"]["password"]?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION["errors"]["login"]["passwordempty"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["login"]["passwordempty"]?></span>
                <?php
            }
            ?>
            <input type="submit" value="Log in" name="login">

            <?php
            if ($_SESSION["errors"]["login"]["status"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["login"]["status"]?></span>
                <?php
            }
            ?>
        </form>

        <div class="reg-cont">
            <h3>Dont have account?</h3>
            <a href="register.php">Register</a>
        </div>
        <div class="reg-cont">
            <h3>Want recover account?</h3>
            <a href="./recover.php">Recover</a>
        </div>
    </div>

</main>
</body>
</html>

