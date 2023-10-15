<?php
	if (isset($_GET['codeStatut'])) {
		$codeStatut = $_GET['codeStatut'];

		if (isset($_POST['modifier'])) {
			$newCodeStatut = htmlspecialchars($_POST['codeStatut']);
			$newLibelleStatut = htmlspecialchars($_POST['libelleStatut']);

			if (isset($newCodeStatut) && !empty($newCodeStatut) && isset($newLibelleStatut) && !empty($newLibelleStatut) ) {
				include_once '../Models/Statut.class.php';
				$statut = Statut::read($codeStatut);
				if ($statut) {
					$statut->update($newCodeStatut, $newLibelleStatut);
				}
				header("Location:../View/statuts.php");
			}
		}
	}
?>