<!DOCTYPE html>
<html>
<head>
    <?php include("Headers/head.php") ?>
</head>
<body class="container-login100" style="background-image: url('../Ressources/Img/decannat_iut.jpg');">

    <!-- Brand Logo -->
    <aside class="main-sidebar">
        <a href="dashboard.php" class="brand-link" style="background-color: #044687;">
            <img src="../Ressources/Dashboard/dist/img/iut.png" alt="Logo iut" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-bold text-white">SCHOSYS</span>
        </a>
    </aside>
    <nav class="main-header navbar navbar-expand navbar-light" style="background-color: #044687;">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link text-white" data-toggle="dropdown" href="#"></a>
        </li>
        </ul>
    </nav>

    <style>
            .container-login100 {
                background-repeat: no-repeat;
                background-size: cover;

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

            .jumbotron {
                font-family: 'Montserrat', sans-serif;
                padding: 35px 0;
                background-color: rgba(0,0,0, 0.0);
                text-align: center;
                color: #fff;
                position: relative;
            }

            .jumbotron h1 {
                font-size: 70px;
                margin-bottom: 0;
            }

            .jumbotron p {
                font-family: serif;
                font-size: 30px;
                font-style: italic;
                margin: 0 0 30px;
            }

            .button {
                display: inline-block;
                border: 2px solid white;
                padding: 10px 20px;
                color: #fff;
                text-decoration: none;
                transition: 0.3s;
            }

            .button:hover {
                background: #044687;
                color: white;
                text-decoration: none;
            }

        </style>
    <section class="jumbotron container">
        <div class="js-tilt" data-tilt style="width: 30%; margin:auto;">
            <img src="../Ressources/Img/iut.png" id="icon" alt="User Icon" />
        </div>
        <h1>SCHOSYS</h1>
        <p class="row">Système de gestion de notes de l'Institut Universitaire de Technologie de l'Université de Parakou (IUT/UP)</p>
        <a href="../connexion" class="button"><i class="fa fa-sign-in" aria-hidden="true" style="margin-right: 10px;"></i>SE CONNECTER</a>

    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../Ressources/asset/js/tilt.jquery.js"></script>
</body>
</html>