<?php 
	if (isset($_GET['idECU'])) {
		$idECU = $_GET['idECU'];

		if (isset($_GET['annee'])) {
			$annee = $_GET['annee'];
			
			include_once '../Models/ECU.class.php';
			$ecu = ECU::read($idECU);
			
			if ($ecu) {
				$ecu->delete();
			}
		}
	}
	header("Location:../View/ecu.php");
?>