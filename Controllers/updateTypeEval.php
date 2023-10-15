<?php
	if (isset($_GET['codeTypeEval'])) {
		$codeTypeEval = $_GET['codeTypeEval'];

		if (isset($_POST['modifier'])) {
			$newCodeTypeEval = htmlspecialchars($_POST['codeTypeEval']);
			$newLibelleTypeEval = htmlspecialchars($_POST['libelleTypeEval']);

			if (isset($newCodeTypeEval) && !empty($newCodeTypeEval) && isset($newLibelleTypeEval) && !empty($newLibelleTypeEval) ) {
				include_once '../Models/TypeEval.class.php';
				$typeeval = TypeEval::read($codeTypeEval);
				if ($typeeval) {
                    
					$typeeval->update($newCodeTypeEval, $newLibelleTypeEval);
				}
				header("Location:../View/typeeval.php");
			}
		}
	}
?>