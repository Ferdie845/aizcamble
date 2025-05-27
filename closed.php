<?php
session_start();
include('includes/db.php');

// Check if the shop is closed
$setting = $conn->query("SELECT * FROM settings WHERE name='shutdown'")->fetch_assoc();
$current = $setting['value'];

$shop_closed = $current == 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop Closed</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            height: 100vh;
            
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url("assets/background.jpg");
        }

        .panel {
            background: hsl(293, 51%, 74%);
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 850px;
            padding: 30px 40px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .panel .logo {
            width: 200px;
            height: 200px;
            border-radius: 100px;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .login-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            padding: 10px 20px;
            background-color: hsl(343, 96%, 89%);
            color: black;
            font-weight: bold;
            text-decoration: none;
            border-radius: 25px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: hsl(293, 51%, 74%);
        }

        .content {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            flex-wrap: wrap;
        }

        .text {
            flex: 1 1 300px;
            padding-right: 20px;
            text-align: left;
        }

        .text h2 {
            font-size: 32px;
            margin: 0 0 15px;
            color: #333;
        }

        .text p {
            font-size: 18px;
            color: #444;
        }

        .closed-img {
            flex: 1 1 300px;
            text-align: center;
        }

        .closed-img img {
            width: 100%;
            max-width: 300px;
            border-radius: 15px;
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
                text-align: center;
            }

            .text {
                padding: 0;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<?php if ($shop_closed): ?>
    <div class="panel">
        <a href="/user/login.php" class="login-btn">Login</a>
        <img src="/assets/FavLogo.jpg" class="logo" alt="Shop Logo">
        <div class="content">
            <div class="text">
                <h2>🚨 The Shop is Closed!</h2>
                <p>We’re currently closed. Please come back later to shop with us again.</p>
            </div>
            <div class="closed-img">
                <img src="/assets/sorry-were-closed-1.jpg" alt="Sorry We're Closed">
            </div>
        </div>
    </div>
<?php else: ?>
    <p>The shop is open!</p>
<?php endif; ?>

</body>
</html>
