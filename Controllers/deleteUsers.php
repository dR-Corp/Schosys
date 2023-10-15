<?php 
	if (isset($_GET['username'])) {
		$username = $_GET['username'];
	}
	
	include '../Models/Utilisateur.class.php';
	$user = Utilisateur::read($username);
	if ($user) {
		$user->delete();
	}
	header("Location:../View/utilisateur.php");
?>