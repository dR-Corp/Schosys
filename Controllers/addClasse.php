<?php
	session_start();
	if (isset($_POST['creer'])) {
		

		if (isset($_POST['idFiliere']) && !empty($_POST['idFiliere'])) {
			if (isset($_POST['idNiveau']) && !empty($_POST['idNiveau'])) {
				if(isset($_POST['annee']) && !empty($_POST['annee'])) {

					
					$annee = htmlspecialchars($_POST['annee']);
					$idFiliere = htmlspecialchars($_POST['idFiliere']);
					$idNiveau = htmlspecialchars($_POST['idNiveau']);

					include_once '../Models/Niveau.class.php';
					include_once '../Models/Filiere.class.php';

					//Génération code classe
					$codeClasse = (Niveau::read($idNiveau))->getCodeNiveau()."-".(Filiere::read($idFiliere))->getCodeFiliere()."-".$annee;

					//Génération libellé classe
					
					$libelleClasse = "";
					//Part1
					if($annee == 1){
						$libelleClasse .= "Première année de ";
					}
					else if($annee == 2){
						$libelleClasse .= "Deuxième année de ";
					}
					else if($annee == 3){
						$libelleClasse .= "Troisième année de ";
					}
					else if($annee == 4){
						$libelleClasse .= "Quatrième année de ";
					}
					else if($annee == 5){
						$libelleClasse .= "Cinquième année de ";
					}
					else{
						$libelleClasse .= "";
					}
					//Part2
					$libelleClasse .= (Niveau::read($idNiveau))->getLibNiveau(). " en ";
					//Part3
					$libelleClasse .= (Filiere::read($idFiliere))->getLibFiliere();

					if (isset($codeClasse) && !empty($codeClasse) && isset($libelleClasse) && !empty($libelleClasse) && isset($idFiliere) && !empty($idFiliere) && isset($idNiveau) && !empty($idNiveau)) {
						
						include_once '../Models/Classe.class.php';
						$idClasse = Classe::genererIdClasse();

						Classe::create($idClasse, $codeClasse, $libelleClasse, $idNiveau, $idFiliere);
					}
				}
			}
			else {
				$_SESSION['alert'] = "error";
				$_SESSION['alert_message'] = "Ajout échoué : il n'existe aucun niveau !";
			}
		}
		else {
			$_SESSION['alert'] = "error";
			$_SESSION['alert_message'] = "Ajout échoué : il n'existe aucune filiere !";
		}
		
	}
	
	header("Location:../View/classes.php");
?>