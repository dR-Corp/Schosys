<?php
	if (isset($_GET['idEvaluation'])) {
		$idEvaluation = $_GET['idEvaluation'];

		if (isset($_POST['modifier'])) {
			
			$newCodeTypeEval = htmlspecialchars($_POST['codeTypeEval']);
			$newIdECU = htmlspecialchars($_POST['idECU']);

			include_once '../Models/ECU.class.php';
			include_once '../Models/TypeEval.class.php';

			$newCodeEvaluation = $newCodeTypeEval.'-'.(ECU::read($newIdECU))->getCodeECU();
			
			//Gestion de l'apostrophe pour le cas où de libelle de l'ECU commence par une voyelle
			$libECU = (ECU::read($newIdECU))->getLibECU();
			$libType = (TypeEval::read($newCodeTypeEval))->getLibTypeEval();
			$l = $libECU;
			if($l[0] == "A" || $l[0] == "E" || $l[0] == "I" || $l[0] == "O" || $l[0] == "U" || $l[0] == "Y") {
				$newLibelleEvaluation = $libType." d'".$libECU;
			}
			else {
				$newLibelleEvaluation = $libType." de ".$libECU;
			}

			if (isset($newCodeEvaluation) && !empty($newCodeEvaluation) && isset($newLibelleEvaluation) && !empty($newLibelleEvaluation) && isset($newCodeTypeEval) && !empty($newCodeTypeEval) && isset($newIdECU) && !empty($newIdECU)) {
				include_once '../Models/Evaluation.class.php';
				$evaluation = Evaluation::read($idEvaluation);
				if ($evaluation) {
                    $evaluation->update($newCodeEvaluation, $newLibelleEvaluation, $newCodeTypeEval, $newIdECU);
				}
			}
		}
	}

	header("Location:../View/evaluations.php");
?>