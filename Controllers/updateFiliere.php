<?php
	if (isset($_GET['idFiliere'])) {
		$idFiliere = $_GET['idFiliere'];

		if (isset($_POST['modifier'])) {
			$newCodeFiliere = htmlspecialchars($_POST['codeFiliere']);
			$newLibelleFiliere = htmlspecialchars($_POST['libelleFiliere']);

			if (isset($newCodeFiliere) && !empty($newCodeFiliere) && isset($newLibelleFiliere) && !empty($newLibelleFiliere) ) {
				include_once '../Models/Filiere.class.php';

				$filiere = Filiere::read($idFiliere);
				if ($filiere) {
					$filiere->update($newCodeFiliere, $newLibelleFiliere);
				}
				header("Location:../View/filieres.php");
			}
		}
	}
?>