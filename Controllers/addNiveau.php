<?php 
	if (isset($_POST['creer'])) {
		$codeNiveau = htmlspecialchars($_POST['codeNiveau']);
		$libelleNiveau = htmlspecialchars($_POST['libelleNiveau']);
		$duree = htmlspecialchars($_POST['duree']);
		$cycle = htmlspecialchars($_POST['cycle']);

		if (isset($codeNiveau) && !empty($codeNiveau) && isset($libelleNiveau) && !empty($libelleNiveau) && isset($duree) && !empty($duree) && isset($cycle) && !empty($cycle)) {
			include_once '../Models/Niveau.class.php';
			$idNiveau = Niveau::genererIdNiveau();
			Niveau::create($idNiveau, $codeNiveau, $libelleNiveau, $duree, $cycle);
			header("Location:../View/niveaux.php");
		}
		
	}
?>