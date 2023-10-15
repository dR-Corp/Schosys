<?php 
	if (isset($_POST['creer'])) {
		$codeStatut = htmlspecialchars($_POST['codeStatut']);
		$libelleStatut = htmlspecialchars($_POST['libelleStatut']);

		if (isset($codeStatut) && !empty($codeStatut) && isset($libelleStatut) && !empty($libelleStatut)) {
			include_once '../Models/Statut.class.php';
			Statut::create($codeStatut, $libelleStatut);
			header("Location:../View/statuts.php");
		}
		
	}
?>