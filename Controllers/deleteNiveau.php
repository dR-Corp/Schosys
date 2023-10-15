<?php 
	if (isset($_GET['idNiveau'])) {
		$idNiveau = $_GET['idNiveau'];

		include_once '../Models/Niveau.class.php';
		$niveau = Niveau::read($idNiveau);
		if ($niveau) {
			$niveau->delete();
		}

	}
	header("Location:../View/niveaux.php");
?>