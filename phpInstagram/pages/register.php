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

    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body>
<main>


    <div class="carousel-cont">
        <div class="carousel" id="imageCarousel">
            <?php
            $imagesDirectory = '../assets/images/carousel/';
            $images = scandir($imagesDirectory);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            foreach ($images as $image) {
                $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

                if (in_array($extension, $allowedExtensions)) {
                    echo '<img src="' . $imagesDirectory . $image . '" alt="Carousel Image">';
                }
            }
            ?>
        </div>
    </div>
    <div class="form-cont">
    <form action="../action/registerAction.php" method="post">
        <h2>Register</h2>
        <label for="full_name">Full Name:</label>
        <input type="text"  name="full_name" id="full_name">
        <?php
         if ($_SESSION['errors']['register']['full_name']){?>
             <span class="error"><?php echo $_SESSION['errors']['register']['full_name'] ?></span>
        <?php
         }
        ?>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <?php
        if ($_SESSION['errors']['register']['username']){?>
            <span class="error"><?php echo $_SESSION['errors']['register']['username'] ?></span>
            <?php
        }
        if ($_SESSION['errors']['register']['username_exist']){?>
            <span class="error"><?php echo $_SESSION['errors']['register']['username_exist'] ?></span>
            <?php
        }
        ?>
        <label for="email">Email:</label>
        <input type="email"  name="email" id="email">
        <?php
        if ($_SESSION['errors']['register']['email']){?>
            <span class="error"><?php echo $_SESSION['errors']['register']['email'] ?></span>
            <?php
        }
        ?>
        <?php
        if ($_SESSION['errors']['register']['email_exist']){?>
            <span class="error"><?php echo $_SESSION['errors']['register']['email_exist'] ?></span>
            <?php
        }
        ?>
        <div class="gender-group">
            <div class="gender-option">
                <p>Gender:</p>
            </div>
            <div class="gender-option" >
                <label for="male">Male</label>
                <input type="radio" name="gender" value="male" id="male" checked>
            </div>
            <div class="gender-option">
                <label for="female">Female</label>
                <input type="radio"  name="gender" value="female" id="female">
            </div>
        </div>

        <label for="password">Password:</label>
        <input type="password"  name="password" id="password">
        <?php
        if ($_SESSION['errors']['register']['password']){?>
            <span class="error"><?php echo $_SESSION['errors']['register']['password'] ?></span>
            <?php
        }
        ?>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password">
        <?php
        if ($_SESSION['errors']['register']['confirm_password_empty']){?>
            <span class="error"><?php echo $_SESSION['errors']['register']['confirm_password_empty'] ?></span>
            <?php
        }
        ?>
        <?php
        if ($_SESSION['errors']['register']['confirm_password_different']){?>
            <span class="error"><?php echo $_SESSION['errors']['register']['confirm_password_different'] ?></span>
            <?php
        }
        ?>
        <input type="submit" value="Register" name="register">
    </form>
        <div class="reg-cont">
            <h3>Already have account?</h3>
            <a href="./login.php">Log in</a>
        </div>
    </div>
</main>

<script src="../assets/js/register.js"></script>
</body>
</html>

