<?php 
	if (isset($_POST['creer'])) {
		

		if(isset($_POST['codeProfil']) && !empty($_POST['codeProfil'])){

			$username = htmlspecialchars($_POST['username']);
			$name = htmlspecialchars($_POST['name']);
			$firstname = htmlspecialchars($_POST['firstname']);
			$email = htmlspecialchars($_POST['email']);
			$password = htmlspecialchars($_POST['password']);
			$codeProfil = htmlspecialchars($_POST['codeProfil']);

			if (isset($username) && !empty($username) && isset($name) && !empty($name) && isset($firstname) && !empty($firstname) && isset($email) && !empty($email) && isset($password) && !empty($password) && isset($codeProfil) && !empty($codeProfil)) {
				
				include '../Models/Utilisateur.class.php';
				Utilisateur::create($username, $name, $firstname, $email, $password, $codeProfil);
				
				header("Location:../View/utilisateur.php");
			}
		}
		else {
			$_SESSION['alert'] = "error";
			$_SESSION['alert_message'] = "Ajout échoué : il n'existe aucun profil !";
		}
		
	}
?>


