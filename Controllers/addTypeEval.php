<?php 
	if (isset($_POST['creer'])) {
		$codeTypeEval = htmlspecialchars($_POST['codeTypeEval']);
		$libelleTypeEval = htmlspecialchars($_POST['libelleTypeEval']);

		if (isset($codeTypeEval) && !empty($codeTypeEval) && isset($libelleTypeEval) && !empty($libelleTypeEval)) {
			include_once '../Models/TypeEval.class.php';
			TypeEval::create($codeTypeEval, $libelleTypeEval);
			header("Location:../View/typeeval.php");
		}
		
	}
?>