<?php 
	if (isset($_GET['codeStatut'])) {
		$codeStatut = $_GET['codeStatut'];
	}
	include_once '../Models/Statut.class.php';
	$statut = Statut::read($codeStatut);
	if ($statut) {
		$statut->delete();
	}
	header("Location:../View/statuts.php");
?>