<?php 
	if (isset($_GET['idFiliere'])) {
		$idFiliere = $_GET['idFiliere'];
	}
	include_once '../Models/Filiere.class.php';
	$filiere = Filiere::read($idFiliere);
	if ($filiere) {
		$filiere->delete();
	}
	header("Location:../View/filieres.php");
?>