<?php

	if (isset($_POST['creer'])) {
		$debut = htmlspecialchars($_POST['debut']);
		$fin = htmlspecialchars($_POST['fin']);

		if (isset($debut) && !empty($debut) && $debut!="Début" && isset($fin) && !empty($fin) && $fin!="Fin") {
			
			$idAnnee = $debut.''.$fin;
			$annee = $debut.'-'.$fin;
			
			include_once '../Models/AnneeAcademique.class.php';
			AnneeAcademique::create($idAnnee, $annee);

			header("Location:../View/annees.php");
		}
		
	}
?>