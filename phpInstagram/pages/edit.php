<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

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
    <link rel="stylesheet" href="../assets/css/edit.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
</head>
<body>
<main>
    <div class="form-cont">
        <form action="../action/editAction.php" method="post" enctype="multipart/form-data">
            <h2>Edit</h2>
            <label for="full_name">Full Name</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo $_SESSION['user']['full_name'] ?>">
            <?php
            if ($_SESSION['errors']['edit']['full_name']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']["edit"]["full_name"] ?></span>
                <?php
            } ?>
            <?php
            if ($_SESSION['errors']['edit']['same_values']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']["edit"]["same_values"] ?></span>
                <?php
            } ?>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo $_SESSION['user']['username'] ?>">
            <?php
            if ($_SESSION['errors']['edit']['username']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']['edit']['username'] ?></span>
                <?php
            }
            if ($_SESSION['errors']['edit']['using_username']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']['edit']['using_username'] ?></span>
                <?php
            }
            if ($_SESSION['errors']['edit']['same_values']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']["edit"]["same_values"] ?></span>
                <?php
            } ?>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo $_SESSION['user']['email'] ?>">
            <?php
            if ($_SESSION['errors']['edit']['email']) {
                ?>
                <span class="error"><?php echo $_SESSION["errors"]["edit"]["email"] ?></span>
                <?php
            }
            if ($_SESSION['errors']['edit']['using_email']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']['edit']['using_email'] ?></span>
                <?php
            }
            if ($_SESSION['errors']['edit']['same_values']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']["edit"]["same_values"] ?></span>
                <?php
            } ?>
            <input type="file" name="update_avatar">
            <?php
            if ($_SESSION['errors']['edit']['wrong_file']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']["edit"]["wrong_file"] ?></span>
                <?php
            } ?>
            <?php
            if ($_SESSION['errors']['edit']['filesize']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']["edit"]["filesize"] ?></span>
                <?php
            } ?>
            <?php
            if ($_SESSION['errors']['edit']['wrong_filetype']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']["edit"]["wrong_filetype"] ?></span>
                <?php
            } ?>
            <?php
            if ($_SESSION['errors']['edit']['dont_upload']) {
                ?>
                <span class="error"><?php echo $_SESSION['errors']["edit"]["dont_upload"] ?></span>
                <?php
            } ?>
            <input type="submit" value="Edit" name="edit">
        </form>
        <div class="reg-cont">
            <button class="pass-btn" id="openPassword">Change password</button>

        </div>
        <div class="reg-cont">
            <button class="pass-btn" id="openDelete">Delete account</button>
        </div>

        <div class="reg-cont">
            <a href="./profile.php">Go Back</a>
        </div>
    </div>
    <div id="modalPass" class="modal">
        <div class="modal-content">
            <form action="../action/editAction.php" method="post" >
                <h2>Change Password</h2>
                <span class="close">&times;</span>
                <label for="current_password">Current passoword</label>
                <input type="password" name="current_password" id="current_password">
                <?php if ($_SESSION['errors']['edit']['current_password']) { ?>
                    <span class="error"><?php echo $_SESSION['errors']["edit"]["current_password"] ?></span>
                    <?php
                } ?>
                <?php if ($_SESSION['errors']['edit']['wrong_password']) { ?>
                    <span class="error"><?php echo $_SESSION['errors']["edit"]["wrong_password"] ?></span>
                    <?php
                } ?>
                <label for="new_password">New passowrd</label>
                <input type="password" name="new_password" id="new_password">
                <?php if ($_SESSION['errors']['edit']['new_password']) { ?>
                    <span class="error"><?php echo $_SESSION['errors']["edit"]["new_password"] ?></span>
                    <?php
                } ?>
                <label for="repeat_password">Repeat new passoword</label>
                <input type="password" name="repeat_password" id="repeat_password"">
                <?php if ($_SESSION['errors']['edit']['repeat_password']) { ?>
                    <span class="error"><?php echo $_SESSION['errors']["edit"]["repeat_password"] ?></span>
                    <?php
                } ?>
                <?php if ($_SESSION['errors']['edit']['repeat_password_empty']) { ?>
                    <span class="error"><?php echo $_SESSION['errors']["edit"]["repeat_password_empty"] ?></span>
                    <?php
                } ?>
                <input type="submit" value="Change password" name="pass_change">
            </form>
        </div>
    </div>
    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <form action="../action/editAction.php" method="post" class="delForm">
                <h2>Delete Account</h2>
                <span class="close">&times;</span>
                <label for="delete_account">Are you sure that you want delete your account?</label>
                <select id="delete_account" name="account_choice">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
                <input type="submit" name="choice">

            </form>
        </div>
    </div>
</main>

<script src="../assets/js/register.js"></script>
<script src="../assets/js/edit.js"></script>
</body>
</html>