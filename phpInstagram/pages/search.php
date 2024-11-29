<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

require_once '../config/config.php';
global $connect;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/search.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <title></title>
</head>
<body>


<?php include '../assets/layout/header.php' ?>

<main>
    <div class="search-box">
            <input id="searchtext" type="text" class="search-bar" placeholder="Search users..." onkeyup="search(event)">
            <label for="search">Search by:</label>
        <select id="search" name="search" onclick="search(event)">
            <option value="username">Username</option>
            <option value="full_name">Full name</option>
            <option value="title">Post title</option>
        </select>


<!--            <input type="submit" value="Search" name="search">-->
    </div>

<div class="result scroll"><h2>Search something...</h2></div>
</main>

<script src="../assets/js/search.js"></script>
</body>
</html>
