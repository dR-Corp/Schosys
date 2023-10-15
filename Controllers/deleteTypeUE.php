<?php 
	if (isset($_GET['codeTypeUE'])) {
		$codeTypeUE = $_GET['codeTypeUE'];
	}
	include_once '../Models/TypeUE.class.php';
	$typeue = TypeUE::read($codeTypeUE);
	if ($typeue) {
		$typeue->delete();
	}
	header("Location:../View/typeue.php");
?>