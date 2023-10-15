<?php 
	if (isset($_POST['creer'])) {
		$codeTypeUE = htmlspecialchars($_POST['codeTypeUE']);
		$libelleTypeUE = htmlspecialchars($_POST['libelleTypeUE']);

		if (isset($codeTypeUE) && !empty($codeTypeUE) && isset($libelleTypeUE) && !empty($libelleTypeUE)) {
			include_once '../Models/TypeUE.class.php';
			TypeUE::create($codeTypeUE, $libelleTypeUE);
			header("Location:../View/typeue.php");
		}
		
	}
?>