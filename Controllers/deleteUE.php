<?php 
	if (isset($_GET['idUE'])) {
		$idUE = $_GET['idUE'];

		if (isset($_GET['annee'])) {
			$annee = $_GET['annee'];
	
			include_once '../Models/UE.class.php';
			$ue = UE::read($idUE);
			if ($ue) {
				$ue->delete();
			}
		}
	}
	header("Location:../View/ue.php");
?>