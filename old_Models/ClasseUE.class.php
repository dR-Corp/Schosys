<?php

class ClasseUE {

	private $codeUE;
	private $codeClasse;

	function __construct($newCodeUE, $newCodeClasse) {

		$this->codeUE = $newCodeUE;
		$this->codeClasse = $newCodeClasse;
		
	}

	public function getCodeClasse() {
		return $this->codeClasse;
	}

	public static function create($codeUE, $codeClasse) {

		$codes = explode(",", $codeClasse);
		$etat = 0;

		include("../Database/database.php");
		
		$select1 = $bdd->query("SELECT * FROM ue WHERE codeUE='$codeUE'");

		if(!empty($select1) && $select1->rowCount()>=1){

			foreach ($codes as $code) {
					if($code ==""){continue;}else{

				$select2 = $bdd->query("SELECT * FROM classe WHERE codeClasse='$code'");

				if(!empty($select2) && $select2->rowCount()>=1){
					$etat = 1;
				}else{$etat = 0;
					  break;
					}
				}
			}
			if($etat==1){

				$select = $bdd->query("SELECT * FROM classe_ue WHERE codeUE='$codeUE' AND codeClasse='$codeClasse' ");

				if(!empty($select) && $select->rowCount() == 1) {
					print "Echec de l'ajout. Cette ue a déjà été associée à cette classe !";
				}
				else {

					$insert = $bdd->prepare("INSERT INTO classe_ue(codeUE, codeClasse) VALUES(?,?)");
					$insert->execute(array($codeUE, $codeClasse));

					print "UE associée à la classe avec succès";
				}

			}else{print "Une de ces classes  n'existe pas; Veuillez fournir une entree valide.";}

		}else{print "Cette unité d'enseignement n'est pas pris en compte; Veuillez vous assurer d'entrer un niveau disponible.";}
		
	}

	public static function read($codeUE) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe_ue WHERE codeUE='$codeUE' ");
		$aClasseUE = $select->fetchAll();
		if(!empty($aClasseUE)) {
			$classeue = new ClasseUE($aClasseUE[0][0], $aClasseUE[0][1]);
			return $classeue;
		}
		else {
			print "Cette UE n'est pas associée à la classe !";
			return false;
		}

	}

	public static function getAllClasseUE() {
		
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe_ue ");
		$allClasseUE = $select->fetchAll();
		return $allClasseUE;
	}

	public function update($newCodeClasse) {

		$codeUE = $this->codeUE;
		$codeClasse = $this->codeClasse;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe_ue WHERE codeUE='$codeUE' AND codeClasse='$codeClasse' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Modification échouée. Cette ClasseUE n'existe pas !";
		}
		else {	
			$update = $bdd->prepare("UPDATE classe_ue SET codeclasse=? WHERE codeUE='$codeUE' AND codeClasse='$codeClasse' ");
			$update->execute(array($newCodeClasse));

			print "La ClasseUE a été modifié avec succès";
		}	
	}

	public static function updateClasse($codeClasse, $newCodeClasse) {

		include('../Database/database.php');

		$classeues = Self::getAllClasseUE();
		foreach($classeues as $classeue) {
			$newclasses = "";
			$classe = $classeue['codeClasse'];
			$codes = explode(",", $classe);

			foreach($codes as $code) {

				if($code == $codeClasse) {
					if(empty($newclasses))
						$newclasses .= $newCodeClasse;
					else
						$newclasses .= ",".$newCodeClasse;
				}
				else {
					if(empty($newclasses))
						$newclasses .= $code;
					else
						$newclasses .= ",".$code;
				}
			}
			$update = $bdd->prepare("UPDATE classe_ue SET codeclasse=? WHERE codeClasse='$classe' ");
			$update->execute(array($newclasses));
		}
	}

	public static function deleteClasse($codeClasse) {

		include('../Database/database.php');

		$classeues = Self::getAllClasseUE();
		foreach($classeues as $classeue) {
			$newclasses = "";
			$classe = $classeue['codeClasse'];
			$codes = explode(",", $classe);

			foreach($codes as $code) {

				if($code != $codeClasse) { //Ajouter toutes les classes sauf celle à supprimer
					if(empty($newclasses))
						$newclasses .= $code;
					else
						$newclasses .= ",".$code;
				}
			}
			$update = $bdd->prepare("UPDATE classe_ue SET codeclasse=? WHERE codeClasse='$classe' ");
			$update->execute(array($newclasses));
		}
	}

	// public function delete($codeUE) {

	// 	include_once('Database/database.php');

	// 	$select = $bdd->query("SELECT * FROM classe_ue WHERE codeUE='$codeUE' AND codeClasse='$codeClasse' ");
	// 	if(!empty($select) && $select->rowCount() == 0) {
	// 		print "Suppression échouée. Cette ClasseUE n'existe pas !";
	// 	}
	// 	else {	
	// 		$delete = $bdd->exec("DELETE FROM classe_ue WHERE codeUE='$codeUE' AND codeClasse'$codeClasse' ");

	// 		print "La ClasseUE a été supprimé avec succès";
	// 	}
	// }

}