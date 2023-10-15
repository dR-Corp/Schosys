<?php 
	if (isset($_POST['creer'])) {
		$codeFiliere = htmlspecialchars($_POST['codeFiliere']);
		$libelleFiliere = htmlspecialchars($_POST['libelleFiliere']);

		if (isset($codeFiliere) && !empty($codeFiliere) && isset($libelleFiliere) && !empty($libelleFiliere)) {
			include '../Models/Filiere.class.php';
			$idFiliere = Filiere::genererIdFiliere();
			Filiere::create($idFiliere,$codeFiliere, $libelleFiliere);
			header("Location:../View/filieres.php");
		}
		
	}
?>