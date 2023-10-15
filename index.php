<?php
    session_start();
	// include_once('Models/Utilisateur.class.php');
	// $user = new Utilisateur("rayid01", "DJERI", "Rayid", "rayidjeri@gmail.com", "147schoosys159", "DA");

	//include("Controllers/data.php");
	//include("Controllers/importerListeEtudiants.php");
	//include("Controllers/importerListeEtudiants.php");
	//include_once('Models/TypeUE.class.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SchooSys</title>
	<meta name="author" content="Carlos & Rayid">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<link rel="stylesheet" type="text/css" href="Ressources/asset/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="Ressources/asset/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="Ressources/css/dash.css" />
    <!--<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>-->
    <script type="text/javascript" src="Ressources/asset/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="Ressources/asset/js/bootstrap.min.js"></script> 

</head>
<body>
	<?php

		if(isset($_SESSION['username'])) {

			header("Location: tableau-de-bord");
			exit();
		}
		else if(isset($_SESSION['echec']) && $_SESSION['echec']=="echec") {

			header("Location: connexion");
			exit();
		}
		else {
			header("Location: accueil");
			exit();
		}
	?>

	<script type="text/javascript" src="Ressources/js/jquery.min.js"></script>
	<script type="text/javascript" src="Ressources/js/popper.min.js"></script>
	<script type="text/javascript" src="Ressources/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="Ressources/js/mdb.min.js"></script>
	<script type="text/javascript"></script>
</body>
</html>

