<?php

	if (isset($_POST['creer'])) {

		if(isset($_POST['codeTypeEval']) && !empty($_POST['codeTypeEval'])) {
			if(isset($_POST['idECU']) && !empty($_POST['idECU'])) {
				
				$codeTypeEval = htmlspecialchars($_POST['codeTypeEval']);
				$idECU = htmlspecialchars($_POST['idECU']);
				
				include_once '../Models/ECU.class.php';
				include_once '../Models/TypeEval.class.php';

				$codeEvaluation = $codeTypeEval.'-'.(ECU::read($idECU))->getCodeECU();

				//Gestion de l'apostrophe pour le cas où de libelle de l'ECU commence par une voyelle
				$libECU = (ECU::read($idECU))->getLibECU();
				$libType = (TypeEval::read($codeTypeEval))->getLibTypeEval();
				$l = $libECU;
				if($l[0] == "A" || $l[0] == "E" || $l[0] == "I" || $l[0] == "O" || $l[0] == "U" || $l[0] == "Y") {
					$libelleEvaluation = $libType." d'".$libECU;
				}
				else {
					$libelleEvaluation = $libType." de ".$libECU;
				}

				if (isset($codeEvaluation) && !empty($codeEvaluation) && isset($libelleEvaluation) && !empty($libelleEvaluation) && isset($codeTypeEval) && !empty($codeTypeEval) && isset($idECU) && !empty($idECU)) {
					include_once '../Models/Evaluation.class.php';
					$idEvaluation = Evaluation::genererIdEvaluation();
					Evaluation::create($idEvaluation, $codeEvaluation, $libelleEvaluation, $codeTypeEval, $idECU);
					
				}
			}
			else {
				$_SESSION['alert'] = "error";
				$_SESSION['alert_message'] = "Ajout échoué : il n'existe aucun ECU !";
			}
		}
		else {
			$_SESSION['alert'] = "error";
			$_SESSION['alert_message'] = "Ajout échoué : il n'existe aucun type d'évaluation !";
		}
	}
	header("Location:../View/evaluations.php");
?>