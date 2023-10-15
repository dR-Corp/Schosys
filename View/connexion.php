<?php
    session_start();
    if(isset($_SESSION['username'])) {
        Header("Location: tableau-de-bord");
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schosys</title>
    <!-- icon -->
    <base href="/Schosys/View/">
    <link rel="icon" href="../Ressources/img/iut.png" type="image/x-icon">
    <link href="../Ressources/Dashboard/plugins/bootstrap4_0/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="../Ressources/Dashboard/plugins/bootstrap4_0/bootstrap.min.js"></script>
    <script src="../Ressources/Dashboard/plugins/bootstrap4_0/jquery.min.js"></script>
    <link rel="stylesheet" href="../Ressources/assets/maxcdn.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Include the above in your HEAD tag -->

</head>

<style>

    html {
        background-color: white;
    }
    body {
        font-family: "Poppins", sans-serif;
        height: 100vh;
    }
    a {
        color: #92badd;
        display:inline-block;
        text-decoration: none;
        font-weight: 400;
    }
    h2 {
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        display:inline-block;
        margin: 40px 8px 10px 8px;
        color: #cccccc;
    }

    /* STRUCTURE */
    .wrapper {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        min-height: 100%;
        padding: 20px;
    }
    #formContent {
        -webkit-border-radius: 10px 10px 10px 10px;
        border-radius: 10px 10px 10px 10px;
        background: #fff;
        padding: 30px;
        width: 90%;
        max-width: 450px;
        position: relative;
        padding: 0px;
        -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
        text-align: center;
    }

    #formHeader {
        background-color: #044687;
        border-top: 1px solid #dce8f1;
        padding: 20px;
        text-align: center;
        -webkit-border-radius: 10px 10px 0 0;
        border-radius: 10px 10px 0 0;
    }

    #formFooter {
        background-color: #f0f0f0;
        border-top: 1px solid #dce8f1;
        padding: 20px;
        text-align: center;
        -webkit-border-radius: 0 0 10px 10px;
        border-radius: 0 0 10px 10px;
    }

    /* TABS */
    h2.inactive {
        color: #cccccc;
    }

    h2.active {
        color: #0d0d0d;
        border-bottom: 2px solid #5fbae9;
    }

    /* FORM TYPOGRAPHY*/

    input[type=button], input[type=submit], input[type=reset]  {
        background-color: #044687;
        border: none;
        color: white;
        padding: 15px 80px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        width: 85%;
        text-transform: uppercase;
        font-size: 13px;
        -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
        box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
        margin: 5px 20px 10px 20px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
        background-color: #001f3f;
    }

    input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
        -moz-transform: scale(0.95);
        -webkit-transform: scale(0.95);
        -o-transform: scale(0.95);
        -ms-transform: scale(0.95);
        transform: scale(0.95);
    }

    input[type=text], input[type=password] {
        background-color: #f0f0f0;
        border: none;
        color: #0d0d0d;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 5px;
        width: 85%;
        border: 2px solid #dcdede;
        -webkit-transition: all 0.5s ease-in-out;
        -moz-transition: all 0.5s ease-in-out;
        -ms-transition: all 0.5s ease-in-out;
        -o-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
        -webkit-border-radius: 5px 5px 5px 5px;
        border-radius: 5px 5px 5px 5px;
    }
    input[type=text]:focus, input[type=password]:focus {
        background-color: #fff;
        border-bottom: 2px solid #5fbae9;
    }
    input[type=text]::placeholder, input[type=password]::placeholder {
        color: #cccccc;
    }

    /* ANIMATIONS */

    /* Simple CSS3 Fade-in-down Animation */
    .fadeInDown {
        -webkit-animation-name: fadeInDown;
        animation-name: fadeInDown;
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }

    @-webkit-keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }
        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            -webkit-transform: translate3d(0, -100%, 0);
            transform: translate3d(0, -100%, 0);
        }
        100% {
            opacity: 1;
            -webkit-transform: none;
            transform: none;
        }
    }

    /* Simple CSS3 Fade-in Animation */
    @-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    @-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    .fade {
        opacity:0;
        -webkit-animation:fadeIn ease-in 1;
        -moz-animation:fadeIn ease-in 1;
        animation:fadeIn ease-in 1;

        -webkit-animation-fill-mode:forwards;
        -moz-animation-fill-mode:forwards;
        animation-fill-mode:forwards;

    }
    .fadeIn {
        opacity:0;
        -webkit-animation:fadeIn ease-in 1;
        -moz-animation:fadeIn ease-in 1;
        animation:fadeIn ease-in 1;

        -webkit-animation-fill-mode:forwards;
        -moz-animation-fill-mode:forwards;
        animation-fill-mode:forwards;

        -webkit-animation-duration:1s;
        -moz-animation-duration:1s;
        animation-duration:1s;
    }
    .fadeIn.first {
        -webkit-animation-delay: 0.4s;
        -moz-animation-delay: 0.4s;
        animation-delay: 0.4s;
    }
    .fadeIn.second {
        -webkit-animation-delay: 0.6s;
        -moz-animation-delay: 0.6s;
        animation-delay: 0.6s;
    }
    .fadeIn.third {
        -webkit-animation-delay: 0.8s;
        -moz-animation-delay: 0.8s;
        animation-delay: 0.8s;
    }
    .fadeIn.fourth {
        -webkit-animation-delay: 1s;
        -moz-animation-delay: 1s;
        animation-delay: 1s;
    }

    /*FORM HEADER*/
    .underlineHovere {
        color:white;
        font-weight: bold;
        font-size: x-large;
    }
    .underlineHovere:hover {
        color: white;
        text-decoration: none;
    }

    /* Simple CSS3 Fade-in Animation */
    .underlineHover:after {
        display: block;
        left: 0;
        bottom: -10px;
        width: 0;
        height: 2px;
        background-color: #56baed;
        content: "";
        transition: width 0.2s;
    }
    .underlineHover:hover {
        color: blue;
        text-decoration: none;
    }
    .underlineHover:hover:after{
        width: 100%;
    }

    /* OTHERS */
    *:focus {
        outline: none;
    }
    #icon {
        width:30%;
    }


    .container-login100 {
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;

    }

    .container-login100::before {
        content: "";
        display: block;
        position: fixed;
        top: 0px;
        width: 100%;
        height: 100%;
        background: white;
        background: -webkit-linear-gradient(bottom, #044687, white);
        background: -o-linear-gradient(bottom, #044687, white);
        background: -moz-linear-gradient(bottom, #044687, white);
        background: linear-gradient(bottom, #044687, white);
        opacity: 0.8;
    }

</style>

<body class="container-login100" style="background-image: url('../Ressources/Img/decannat_iut.jpg');">

    <div class="wrapper">

        <div id="formContent">
            <div id="formHeader">
                <a class="underlineHovere" href="accueil.php">SCHOSYS</a>
            </div>
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn second js-tilt" data-tilt>
                <img src="../Ressources/Img/iut.png" id="icon" alt="app icon" />
            </div>

            <?php

                if(isset($_SESSION['echec']) && $_SESSION['echec']=="echec") {
                    //afficher l'alert pour echec de connexion
                    $message = "Echec de connexion : Nom d'utilisateur ou mot de passe incorrect";
                    include_once("Alerts/connexion_alert.php");
                    $_SESSION['echec']=="";
                }
                else if(isset($_SESSION['empty']) && $_SESSION['empty']=="empty") {
                    //afficher l'alert pour echec de connexion
                    $message = "Veuillez remplir tous les champs svp !";
                    include_once("Alerts/connexion_alert.php");
                    $_SESSION['empty']=="";
                }
            ?>
            <!-- Login Form -->
            <form  method="post" action="../Controllers/connexion.php">
                <input type="text" id="username" class="fade" name="username" placeholder="Nom d'utilisateur" required>
                <br><br><input type="password" id="password" class="fade" name="password" placeholder="Mot de passe" required>
                <br><br><input type="submit" class="fade" value="Connexion" name="connexion">
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="#">Mot de passe oublié !</a>
            </div>

        </div>
    </div>

    <script src="../Ressources/Dashboard/plugins/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="../Ressources/Dashboard/plugins/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="../Ressources/Dashboard/plugins/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../Ressources/asset/js/tilt.jquery.js"></script>

    <script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
</body>
</html>

