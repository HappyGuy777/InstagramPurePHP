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
    <title>Chat Page</title>
    <link rel="stylesheet" href="../assets/css/chat.css">
    <link rel="stylesheet" href="../assets/css/header.css">
</head>
<body>
<?php include '../assets/layout/header.php' ?>
<main>
    <div class="chat-cont sm">

        <div class="chat-list-cont">
            <div class="username-cont">
                <p><?php echo $_SESSION['user']['username']?></p>
                <a href="#">
                    <svg aria-label="Новое сообщение" class="x1lliihq x1n2onr6" color="rgb(0, 0, 0)" fill="rgb(0, 0, 0)"
                         height="24" role="img" viewBox="0 0 24 24" width="24">
                        <path d="M12.202 3.203H5.25a3 3 0 0 0-3 3V18.75a3 3 0 0 0 3 3h12.547a3 3 0 0 0 3-3v-6.952"
                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"></path>
                        <path d="M10.002 17.226H6.774v-3.228L18.607 2.165a1.417 1.417 0 0 1 2.004 0l1.224 1.225a1.417 1.417 0 0 1 0 2.004Z"
                              fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"></path>
                        <line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" x1="16.848" x2="20.076" y1="3.924" y2="7.153"></line>
                    </svg>
                </a>
            </div>
            <div class="username-cont row2">
                <button class="chat-buttons">Chats</button>
                <button class="chat-buttons">Chat requests</button>
            </div>
            <ul class="chat-list">
                <li data-user-id="1">
                    <img src="../uploads/avatars/male.png" alt="User 1 Avatar">
                    User 1
                </li>
                <li data-user-id="2">
                    <img src="../uploads/avatars/female.png" alt="User 2 Avatar">
                    User 2
                </li>
                <li data-user-id="3">
                    <img src="../uploads/avatars/male.png" alt="User 3 Avatar">
                    User 3
                </li>
            </ul>
        </div>
    </div>

    <div class="chat-cont big">
        <form class="chat-window">
            <h2>Chat with somebody</h2>
            <div class="chat-messages">


            </div>
            <div class="message-input">
                <input type="text" id="message" placeholder="Type a message...">
                <button id="send">Send</button>
            </div>
        </form>
    </div>

</main>
</body>
</html>
