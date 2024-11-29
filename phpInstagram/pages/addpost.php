<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

require_once '../config/config.php';
global $connect;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<?php
include '../assets/layout/header.php'
?>

<main>
    <div class="form-cont">
        <form action="../action/addpostAction.php" method="post" class="add_post" enctype="multipart/form-data">
            <h2>Add post</h2>
            <label for="title">Post title</label>
            <input type="text" name="title" id="title" placeholder="Max 40 symbols" maxlength="40">
            <?php
            if ($_SESSION['error']["add_post"]["title"]) {
                ?>
                <span class="error"><?php echo $_SESSION['error']["add_post"]["title"] ?></span>
                <?php
            }
            ?>
            <label for="post_text">Post text</label>
            <textarea name="post_text" id="post_text" cols="50" rows="15" placeholder="Max 600 symbols"
                      maxlength="600"></textarea>
            <label for="images">Images</label>
            <input type="file" name="images[]" id="images" multiple>
            <?php
            if ($_SESSION['error']["add_post"]["empty_image"]) {
                ?>
                <span class="error"><?php echo $_SESSION['error']["add_post"]["empty_image"] ?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['error']["add_post"]["not_image"]) {
                ?>
                <span class="error"><?php echo $_SESSION['error']["add_post"]["not_image"] ?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['error']["add_post"]["max_count"]) {
                ?>
                <span class="error"><?php echo $_SESSION['error']["add_post"]["max_count"] ?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['error']["add_post"]["image_exist"]) {
                ?>
                <span class="error"><?php echo $_SESSION['error']["add_post"]["image_exist"] ?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['error']["add_post"]["file_size"]) {
                ?>
                <span class="error"><?php echo $_SESSION['error']["add_post"]["file_size"] ?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['error']["add_post"]["file_type"]) {
                ?>
                <span class="error"><?php echo $_SESSION['error']["add_post"]["file_type"] ?></span>
                <?php
            }
            ?>
            <?php
            if ($_SESSION['error']["add_post"]["result"]) {
                ?>
                <span class="error"><?php echo $_SESSION['error']["add_post"]["result"] ?></span>
                <?php
            }
            ?>
            <label for="location">Location</label>
            <input type="text" name="location" id="location" placeholder="Max 40 symbols" maxlength="40">
            <label for="comments">Comments</label>
            <select id="comments" name="comments">
                <option value="On">On</option>
                <option value="Off">Off</option>
            </select>
            <label for="likes">Likes</label>
            <select id="likes" name="likes">
                <option value="show">Show likes amount</option>
                <option value="dont_show">Dont show likes amount</option>
            </select>

            <input type="submit" value="Add post" name="add_post">
        </form>

    </div>
</main>
</body>
</html>