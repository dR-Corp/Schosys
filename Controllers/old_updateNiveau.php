<?php
	if (isset($_GET['idNiveau'])) {
		$idNiveau = $_GET['idNiveau'];

		if (isset($_POST['modifier'])) {
			$newCodeNiveau = htmlspecialchars($_POST['codeNiveau']);
			$newLibelleNiveau = htmlspecialchars($_POST['libelleNiveau']);
			$duree = htmlspecialchars($_POST['duree']);

			if (isset($newCodeNiveau) && !empty($newCodeNiveau) && isset($newLibelleNiveau) && !empty($newLibelleNiveau) && isset($duree) && !empty($duree) ) {
				include_once '../Models/Niveau.class.php';
				$niveau = Niveau::read($idNiveau);
				if ($niveau) {
					$niveau->update($newCodeNiveau, $newLibelleNiveau, $duree);
				}
				header("Location:../View/niveaux.php");
			}
		}
	}
?>