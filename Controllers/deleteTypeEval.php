<?php 
	if (isset($_GET['codeTypeEval'])) {
		$codeTypeEval = $_GET['codeTypeEval'];
	}
	include_once '../Models/TypeEval.class.php';
	$typeeval = TypeEval::read($codeTypeEval);
	if ($typeeval) {
		$typeeval->delete();
	}
	header("Location:../View/typeeval.php");
?>