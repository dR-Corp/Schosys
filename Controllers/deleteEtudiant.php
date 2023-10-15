<?php 
	if (isset($_GET['idEtudiant'])) {
		$idEtudiant = $_GET['idEtudiant'];
	
		if (isset($_GET['annee'])) {
			$annee = $_GET['annee'];

			include_once '../Models/Etudiant.class.php';
			$etudiant = Etudiant::read($idEtudiant);
			if ($etudiant) {
				$etudiant->delete();
			}

		}

	}
	header("Location:../View/etudiants.php");
?>