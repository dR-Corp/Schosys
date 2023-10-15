<?php 
	if (isset($_GET['idAnnee'])) {
		$idAnnee = $_GET['idAnnee'];
	}
	include_once '../Models/AnneeAcademique.class.php';
	$annee = AnneeAcademique::read($idAnnee);
	if ($annee) {
		$annee->delete();
	}
	header("Location:../View/annees.php");
?>