<?php
	if (isset($_GET['idClasse'])) {
		$idClasse = $_GET['idClasse'];

		if (isset($_POST['modifier'])) {
			//$newCodeClasse = $_POST['codeClasse'];
			//$newLibelleClasse = $_POST['libelleClasse'];
			
            $newIdFiliere = htmlspecialchars($_POST['idFiliere']);
			$newIdNiveau = htmlspecialchars($_POST['idNiveau']);
			
			$newAnnee = $_POST['annee']; 

			//Génération code classe
			include_once '../Models/Niveau.class.php';
			include_once '../Models/Filiere.class.php';
			$newCodeClasse = (Niveau::read($newIdNiveau))->getCodeNiveau()."-".(Filiere::read($newIdFiliere))->getCodeFiliere()."-".$newAnnee;

			//Génération libellé classe
			
			$newLibelleClasse = "";
			//Part1
			if($newAnnee == 1){
				$newLibelleClasse .= "Première année de ";
			}
			else if($newAnnee == 2){
				$newLibelleClasse .= "Deuxième année de ";
			}
			else if($newAnnee == 3){
				$newLibelleClasse .= "Troisième année de ";
			}
			else if($newAnnee == 4){
				$newLibelleClasse .= "Quatrième année de ";
			}
			else if($newAnnee == 5){
				$newLibelleClasse .= "Cinquième année de ";
			}else if($newAnnee == 6){
				$newLibelleClasse .= "Sixième année de ";
			}
			else if($newAnnee == 7){
				$newLibelleClasse .= "Septième année de ";
			}
			else if($newAnnee == 8){
				$newLibelleClasse .= "Huitième année de ";
			}
			else{
				$newLibelleClasse .= "";
			}
			//Part2
			$newLibelleClasse .= (Niveau::read($newIdNiveau))->getLibNiveau(). " en ";
			//Part3
			$newLibelleClasse .= (Filiere::read($newIdFiliere))->getLibFiliere();

			if (isset($newCodeClasse) && !empty($newCodeClasse) && isset($newLibelleClasse) && !empty($newLibelleClasse) && isset($newIdFiliere) && !empty($newIdFiliere) && isset($newIdNiveau) && !empty($newIdNiveau)) {
				include_once '../Models/Classe.class.php';
				$classe = Classe::read($idClasse);
				if ($classe) {
					$classe->update($newCodeClasse, $newLibelleClasse, $newIdNiveau, $newIdFiliere);

					//On ne fait plus cette modification car c'est l'idClasse qui se trouve maintenant dans ClasseUE et ce dernier ne change pas.
					// include_once '../Models/ClasseUE.class.php';
					// ClasseUE::updateClasse($codeClasse, $newCodeClasse);
				}
			}
		}
	}

	header("Location:../View/classes.php");
?>