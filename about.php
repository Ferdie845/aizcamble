<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>About Us - AizScramble</title>

    <!-- Favicon -->
    <link rel="icon" href="/assets/FavLogo.jpg" alt="brand-logo">

    <!-- Viewport Settings -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Head Info -->
    <meta name="description" content="AizScramble Website">
    <meta name="keywords" content="HTML, CSS">
    <meta name="author" content="Code-a-Holics">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Inline CSS -->
    <style>
        body {
            margin: 0;
            background-color: #fec7d7;
            font-family: Tahoma, Verdana, sans-serif;
            color: #3C3D37;
        }

        nav {
            background-color: #D69ADE;
            width: 100%;
            height: 135px;
            position: fixed;
            top: 0;
        }

        .logo {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            position: relative;
            top: 20px;
            left: 845px;
        }

        a {
            text-decoration: none;
            color: #3C3D37;
        }

        .links-container {
            text-decoration: none;
            color: #3C3D37;
            margin-top: -150px;
            font-weight: bold;
        }

        .link {
            margin-left: 120px;
            font-size: 21px;
        }

        .l1 {
            margin-left: 1000px;
        }

        .l2 {
            margin-left: 20px;
        }

        a:hover {
            color: #fec7d7;
            text-shadow: 0 0 10px #fec7d7;
        }

        main {
            width: 100%;
            height: 650px;
            background-color: #f8b3c7;
            margin-top: 250px;
        }

        .abt {
            text-indent: 70px;
            font-size: 20px;
            position: relative;
            top: 80px;
            margin-left: 780px;
            line-height: 30px;
        }

        .p1, .p2, .p3, .p4, .p5, .p6, .p7, .p8 {
            border-radius: 15%;
            position: relative;
        }

        .p1 {
            top: -150px;
            left: 70px;
        }

        .p2 {
            top: -150px;
            left: 130px;
        }

        .p3 {
            left: -440px;
            top: 150px;
        }

        .p4 {
            top: 150px;
            left: -380px;
        }

        .p5 {
            top: 150px;
            left: -330px;
        }

        .p6 {
            top: 150px;
            left: -280px;
        }

        .p7 {
            top: 150px;
            left: -230px;
        }

        .p8 {
            top: -105px;
            left: 1600px;
        }
    </style>

</head>

<body>

    <nav>
        <div class="brand-logo">
            <a href="Home.php">
                <img class="logo" src="/assets/FavLogo.jpg" alt="Logo">
            </a>
        </div>

        <div class="links-container">
            <a class="link" href="index.php">Home</a>
            <a class="link" href="Home.php">Shop</a>
            <a class="link" href="About.php">About Us</a>
            <a class="link" href="Visit.php">Visit Us</a>
            
        </div>
    </nav>

    <main>
        <div class="pics-for-about">

            <p class="abt">
                Aiz Scramble was launched in 2021 in Sta Cruz Angat Bulacan. We began with the concept of producing <br>Ice Scramble and Mini Donuts that would be
                having been inspired by my own ideas via online. The "look"<br>for our products would be simple and stylized, interesting yet refined. The taste; tasty and
                homemade. We are<br>able to construct a mini cart in December 2021 that is situated in front of our house in Angat Bulacan.The<br>community has accepted us with open arms and we look
                toward becoming an even larger part of <br>the community each and every year.
            </p>

            <img class="p1" src="/assets/pic1.jpg" width="250px" height="250px" alt="Pic1">
            <img class="p2" src="/assets/pic 2.jpg" width="250px" height="250px" alt="Pic2">
            <img class="p3" src="/assets/cart.jpg" width="250px" height="250px" alt="Cart">
            <img class="p4" src="/assets/pic4.jpg" width="250px" height="250px" alt="Pic4">
            <img class="p5" src="/assets/Pic5.jpg" width="250px" height="250px" alt="Pic5">
            <img class="p6" src="/assets/pic6.jpg" width="250px" height="250px" alt="Pic6">
            <img class="p7" src="/assets/pic7.jpg" width="250px" height="250px" alt="Pic7">
            <img class="p8" src="/assets/pic8.jpg" width="250px" height="250px" alt="Pic8">

        </div>
    </main>

</body>
</html>
