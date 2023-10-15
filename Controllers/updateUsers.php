<?php
	if (isset($_GET['username'])) {
		$username = $_GET['username'];

		if (isset($_POST['modifier'])) {
			$newUsername = htmlspecialchars($_POST['username']);
			$newName = htmlspecialchars($_POST['name']);
			$newFirstname = htmlspecialchars($_POST['firstname']);
			$newEmail = htmlspecialchars($_POST['email']);
			$newPassword = htmlspecialchars($_POST['password']);
			$newCodeProfil = htmlspecialchars($_POST['codeProfil']);

			if (isset($newUsername) && !empty($newUsername) && isset($newName) && !empty($newName) && isset($newFirstname) && !empty($newFirstname) && isset($newEmail) && !empty($newEmail) && isset($newCodeProfil) && !empty($newCodeProfil) && empty($newPassword) ) {
				include '../Models/Utilisateur.class.php';
				$user = Utilisateur::read($username);
				if ($user) {
					$user->update($newUsername, $newName, $newFirstname, $newEmail, $newCodeProfil);
				}
				header("Location:../View/utilisateur.php");
			}
			else if(isset($newPassword) && !empty($newPassword) && isset($newUsername) && !empty($newUsername) && isset($newName) && !empty($newName) && isset($newFirstname) && !empty($newFirstname) && isset($newEmail) && !empty($newEmail) && isset($newCodeProfil) && !empty($newCodeProfil)) {
				include '../Models/Utilisateur.class.php';
				$user = Utilisateur::read($username);
				if ($user) {
					$user->updatePwd($newUsername, $newName, $newFirstname, $newEmail, $newPassword, $newCodeProfil);
				}
				header("Location:../View/utilisateur.php");
			}
		}
	}
?>