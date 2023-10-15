<?php
	if (isset($_GET['idAnnee'])) {
		$idAnnee = $_GET['idAnnee'];

		if (isset($_POST['modifier'])) {
			$debut = htmlspecialchars($_POST['date_debut']);
			$fin = htmlspecialchars($_POST['date_fin']);
			$newIdAnnee = $debut.''.$fin;
			$newAnnee = $debut.'-'.$fin;

			if (isset($debut) && !empty($debut) && $debut!="Début" && isset($fin) && !empty($fin) && $fin!="Fin") {
				include_once '../Models/AnneeAcademique.class.php';
				$annee = AnneeAcademique::read($idAnnee);
				if ($annee) {
					$annee->update($newIdAnnee, $newAnnee);
				}
				header("Location:../View/annees.php");
			}
		}
	}
?>