<?php 
	if (isset($_POST['creer'])) {
		$codeNiveau = htmlspecialchars($_POST['codeNiveau']);
		$libelleNiveau = htmlspecialchars($_POST['libelleNiveau']);
		$duree = htmlspecialchars($_POST['duree']);

		if (isset($codeNiveau) && !empty($codeNiveau) && isset($libelleNiveau) && !empty($libelleNiveau) && isset($duree) && !empty($duree)) {
			include_once '../Models/Niveau.class.php';
			$idNiveau = Niveau::genererIdNiveau();
			Niveau::create($idNiveau, $codeNiveau, $libelleNiveau, $duree);
			header("Location:../View/niveaux.php");
		}
		
	}
?>