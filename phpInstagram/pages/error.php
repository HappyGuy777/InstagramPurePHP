<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background-color: #000;
        }

        .error-container {
            position: absolute;
            top: 50%;
            left: 0%;
            transform: translate(-50%, -50%);
            font-size: 48px;
            color: #ff0000;
        }

        .error-animation {
            animation: moveError 5s linear infinite, flicker 0.1s alternate infinite;
        }

        @keyframes moveError {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc(100vw - 100px));
            }
        }

        @keyframes flicker {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0.5;
            }
        }
    </style>
</head>
<body>
<div class="error-container">
    <div class="error-animation">ERROR</div>
</div>
</body>
</html>
