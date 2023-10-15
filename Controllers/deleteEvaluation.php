<?php 
	if (isset($_GET['idEvaluation'])) {
		$idEvaluation = $_GET['idEvaluation'];

		if (isset($_GET['annee'])) {
			$annee = $_GET['annee'];
	
			include_once '../Models/Evaluation.class.php';
			$evaluation = Evaluation::read($idEvaluation);

			if ($evaluation) {
				$evaluation->delete();
			}

		}
		
	}
	header("Location:../View/evaluations.php");
?>