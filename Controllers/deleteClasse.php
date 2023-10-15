<?php 
	if (isset($_GET['idClasse'])) {
		$idClasse = $_GET['idClasse'];

		if (isset($_GET['annee'])) {
			$annee = $_GET['annee'];

			include_once '../Models/Classe.class.php';
			$classe = Classe::read($idClasse);
			if ($classe) {
				$classe->delete();

				include_once '../Models/ClasseUE.class.php';
				ClasseUE::deleteClasse($idClasse, $annee);
			}
		}
	}
	header("Location:../View/classes.php");
?>