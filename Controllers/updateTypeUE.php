<?php
	if (isset($_GET['codeTypeUE'])) {
		$codeTypeUE = $_GET['codeTypeUE'];

		if (isset($_POST['modifier'])) {
			$newCodeTypeUE = htmlspecialchars($_POST['codeTypeUE']);
			$newLibelleTypeUE = htmlspecialchars($_POST['libelleTypeUE']);

			if (isset($newCodeTypeUE) && !empty($newCodeTypeUE) && isset($newLibelleTypeUE) && !empty($newLibelleTypeUE) ) {
				include_once '../Models/TypeUE.class.php';
				$typeue = TypeUE::read($codeTypeUE);
				if ($typeue) {
                    
					$typeue->update($newCodeTypeUE, $newLibelleTypeUE);
				}
				header("Location:../View/typeue.php");
			}
		}
	}
?>