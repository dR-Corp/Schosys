<?php
	if (isset($_GET['idECU'])) {
		$idECU = $_GET['idECU'];

		if (isset($_POST['modifier'])) {
			$newcodeECU = htmlspecialchars($_POST['codeECU']);
            $newLibelleECU = htmlspecialchars($_POST['libelleECU']);
            $newIdUE = htmlspecialchars($_POST['idUE']);

			if (isset($newcodeECU) && !empty($newcodeECU) && isset($newLibelleECU) && !empty($newLibelleECU) && isset($newIdUE) && !empty($newIdUE)) {
				include_once '../Models/ECU.class.php';
				include_once '../Models/TypeEval.class.php';
				include_once '../Models/Evaluation.class.php';
				include_once '../Models/AnneeAcademique.class.php';
				$ecu = ECU::read($idECU);
				if ($ecu) {
					$ecu->update($newcodeECU, $newLibelleECU, $newIdUE);

					$encours = (AnneeAcademique::encours())->getIdAnnee();
					$evaluations = Evaluation::getAllEvaluation($encours);

					foreach($evaluations as $evaluation) {
						
						if( $evaluation['idECU'] == $ecu->getIdECU()) {
							
							$newCodeTypeEval = $evaluation['codeTypeEval'];
							$newIdECU = $idECU;

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
								$evaluation = Evaluation::read($evaluation['idEvaluation']);
								if ($evaluation) {
									$evaluation->update($newCodeEvaluation, $newLibelleEvaluation, $newCodeTypeEval, $newIdECU);
								}
							}

						}
					}

				}
				header("Location:../View/ecu.php");
			}
		}
	}
?>