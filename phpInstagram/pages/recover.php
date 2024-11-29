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
        <form action="../action/recoverAction.php" method="post">
            <h2>Recover Account</h2>
            <label for="username">Username or account E-mail:</label>
            <input type="text" id="username" name="username" placeholder="Username or Email" >
            <?php
            if ($_SESSION["errors"]["recover"]["username"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["recover"]["username"]?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION["errors"]["recover"]["emailuser"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["recover"]["emailuser"]?></span>
                <?php
            }
            ?>
            <label for="password">Account password:</label>
            <input type="password" id="password" name="password"  >
            <?php
            if ($_SESSION["errors"]["recover"]["password"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["recover"]["password"]?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION["errors"]["recover"]["passwordempty"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["recover"]["passwordempty"]?></span>
                <?php
            }
            ?>
            <input type="submit" value="Recover" name="recover">

            <?php
            if ($_SESSION["errors"]["recover"]["status"]){?>
                <span class="error"><?php echo $_SESSION["errors"]["recover"]["status"]?></span>
                <?php
            }
            ?>
        </form>

        <div class="reg-cont">
            <a href="./login.php">Go back</a>
        </div>
    </div>

</main>
</body>
</html>

