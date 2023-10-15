<?php 
	if (isset($_GET['codeProfil'])) {
		$codeProfil = $_GET['codeProfil'];
	}
	include ('../Models/ProfilUser.class.php');
	$profil = ProfilUser::read($codeProfil);
	if ($profil) {
		$profil->delete();
	}else{
		print "Suppression échouée !";
	}
	header("Location:../View/profilUsers.php");
?>