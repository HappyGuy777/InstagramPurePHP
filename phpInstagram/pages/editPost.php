<?php
session_start();
include_once '../config/config.php';
global $connect;
$post_id = $_GET['post_id'];
$user_id=$_SESSION['user']['id'];
$sql = "SELECT * FROM `posts` WHERE `id` = $post_id AND `user_id` = $user_id";
$check = mysqli_query($connect, $sql);

if (mysqli_num_rows($check) == 0) {
    header('Location: ./error.php');
}

$sql = "SELECT * FROM `post_images` WHERE `post_id` = $post_id";

$images = mysqli_query($connect, $sql);
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
    <link rel="stylesheet" href="../assets/css/editpost.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
</head>
<body>
<?php include '../assets/layout/header.php' ?>
<main>

    <form action="../action/addImageAction.php?post_id=<?= $post_id?>" method="post" class="main_form" enctype="multipart/form-data">
        <h2>Edit post</h2>
        <label for="title">Update title</label>
        <input type="text" name="title" id="title" placeholder="Max 40 symbols" maxlength="40">
        <?php
        if ($_SESSION['error']["add_post"]["title"]) {
            ?>
            <span class="error"><?php echo $_SESSION['error']["add_post"]["title"] ?></span>
            <?php
        }
        ?>
        <label for="post_text">Update text</label>
        <textarea name="post_text" id="post_text" cols="50" rows="15" placeholder="Max 600 symbols"
                  maxlength="600"></textarea>
        <label for="images">Add images</label>
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
        <label for="location">Update Location</label>
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

        <input type="submit" value="Add image" name="add_image">
    </form>
    <div class="reg-cont">
        <button class="pass-btn" id="openDelete">Delete post</button>
    </div>
    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <form action="../action/deletePostAction.php?post_id=<?=$post_id?>" method="post" class="delForm">
                <h2>Delete post</h2>
                <span class="close">&times;</span>
                <label for="delete_account">Are you sure that you want delete your post?</label>
                <select id="delete_account" name="account_choice">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
                <input type="submit" name="choice">

            </form>
        </div>
        </div>
    <div class="posts">

        <?php
        $images_count=mysqli_num_rows($images);
        foreach ($images as $image) {
            ?>
            <div id="image<?= $image['id'] ?>" class="post">
                <h2 onclick="deleteImg(<?= $image['id']?>,<?=$images_count?>)">X</h2>
                <img style="width: 200px" src="<?= $image['url'] ?>" alt="">
            </div>
            <?php
        }

        ?>

    </div>

</main>


<script src="../assets/js/editPost.js"></script>
</body>
</html>