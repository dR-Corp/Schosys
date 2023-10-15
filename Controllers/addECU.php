<?php 
	if (isset($_POST['creer'])) {

		if(isset($_POST['idUE']) && !empty($_POST['idUE'])) {

			include_once '../Models/ECU.class.php';
			include_once '../Models/Evaluation.class.php';
			include_once '../Models/AnneeAcademique.class.php';
			include_once '../Models/TypeEval.class.php';

			$codeECU= htmlspecialchars($_POST['codeECU']);
			$libelleECU = htmlspecialchars($_POST['libelleECU']);
			$idUE = htmlspecialchars($_POST['idUE']);

			if (isset($codeECU) && !empty($codeECU) && isset($libelleECU) && !empty($libelleECU) && isset($idUE) && !empty($idUE)) {
				
				$idECU = ECU::genererIdECU();
				$create = ECU::create($idECU, $codeECU, $libelleECU, $idUE);

				// $encours = (AnneeAcademique::encours())->getIdAnnee();
				// $evaluations = TypeEval::getAllTypeEval();

				// if(ECU::read($idECU)) {
				// 	foreach($evaluations as $evaluation) {

				// 		$codeTypeEval = $evaluation['codeTypeEval'];

				// 		$codeEvaluation = $codeTypeEval.'-'.(ECU::read($idECU))->getCodeECU();

				// 		//Gestion de l'apostrophe pour le cas où de libelle de l'ECU commence par une voyelle
				// 		$libECU = (ECU::read($idECU))->getLibECU();
				// 		$libType = (TypeEval::read($codeTypeEval))->getLibTypeEval();
				// 		$l = $libECU;
				// 		if($l[0] == "A" || $l[0] == "E" || $l[0] == "I" || $l[0] == "O" || $l[0] == "U" || $l[0] == "Y") {
				// 			$libelleEvaluation = $libType." d'".$libECU;
				// 		}
				// 		else {
				// 			$libelleEvaluation = $libType." de ".$libECU;
				// 		}

				// 		if (isset($codeEvaluation) && !empty($codeEvaluation) && isset($libelleEvaluation) && !empty($libelleEvaluation) && isset($codeTypeEval) && !empty($codeTypeEval) && isset($idECU) && !empty($idECU)) {
							
				// 			$idEvaluation = Evaluation::genererIdEvaluation();
				// 			Evaluation::create($idEvaluation, $codeEvaluation, $libelleEvaluation, $codeTypeEval, $idECU);
							
				// 		}
						
				// 	}
				// }
			}
		}
		else {
			$_SESSION['alert'] = "error";
			$_SESSION['alert_message'] = "Ajout échoué : il n'existe aucune UE !";
		}
		
	}

	header("Location:../View/ecu.php");
?>