<?php

class ClasseUE {

	private $idUE;
	private $idClasse;

	function __construct($newidUE, $newidClasse) {

		$this->idUE = $newidUE;
		$this->idClasse = $newidClasse;
		
	}

	public function getidClasse() {
		return $this->idClasse;
	}

	public function getIdUE() {
		return $this->idUE;
	}


	public static function create($idUE, $idClasse) {
		
		$ids = explode(",", $idClasse);
		$etat = 0;

		include("../Database/database.php");
		
		$select1 = $bdd->query("SELECT * FROM ue WHERE idUE='$idUE'");

		if(!empty($select1) && $select1->rowCount()>=1){

			foreach ($ids as $id) {
					if($id ==""){continue;}else{

				$select2 = $bdd->query("SELECT * FROM classe WHERE idClasse='$id'");

				if(!empty($select2) && $select2->rowCount()>=1){
					$etat = 1;
				}else{$etat = 0;
					  break;
					}
				}
			}
			if($etat==1){

				$select = $bdd->query("SELECT * FROM classe_ue WHERE idUE='$idUE' AND idClasse='$idClasse' ");

				if(!empty($select) && $select->rowCount() == 1) {
					print "Echec de l'ajout. Cette ue a déjà été associée à cette classe !";
				}
				else {

					$insert = $bdd->prepare("INSERT INTO classe_ue(idUE, idClasse) VALUES(?,?)");
					$insert->execute(array($idUE, $idClasse));

					print "UE associée à la classe avec succès";
				}

			}else{print "Une de ces classes  n'existe pas; Veuillez fournir une entree valide.";}

		}else{print "Cette unité d'enseignement n'est pas pris en compte; Veuillez vous assurer d'entrer un niveau disponible.";}
		
	}

	public static function read($idUE) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe_ue WHERE idUE='$idUE'");
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

	public static function findClasseId($codeUE) {
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();
		if($encours) {
			$annee = $encours->getIdAnnee();
		}
		
		$select = $bdd->query("SELECT * FROM niveau WHERE idNiveau LIKE '$annee%' AND codeNiveau='$codeNiveau' ");
		$aNiveau = $select->fetchAll();
		if(!empty($aFiliere)) {
			$niveau = new Niveau($aNiveau[0][0], $aNiveau[0][1], $aNiveau[0][2], $aNiveau[0][3]);
			return $niveau;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : ce niveau n\'existe pas !';
			return false;
		}
	}

	public static function getAllClasseUE($annee) {
		
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe_ue WHERE idUE LIKE '$annee%' ");
		$allClasseUE = $select->fetchAll();
		return $allClasseUE;
	}

	public static function getClasseAllUE($idClasse) {
		
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe_ue WHERE idClasse LIKE '%$idClasse%' ");
		$allClasseUE = $select->fetchAll();
		return $allClasseUE;
	}

	public function update($newIdClasse) {

		$idUE = $this->idUE;
		$idClasse = $this->idClasse;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe_ue WHERE idUE='$idUE' AND idClasse='$idClasse' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Modification échouée. Cette ClasseUE n'existe pas !";
		}
		else {
			$update = $bdd->prepare("UPDATE classe_ue SET idClasse=? WHERE idUE='$idUE' AND idClasse='$idClasse' ");
			$update->execute(array($newIdClasse));

			print "La ClasseUE a été modifié avec succès";
		}	
	}

	public static function deleteClasse($idClasse, $annee) {

		include('../Database/database.php');
		include_once '../Models/UE.class.php';

		$classeues = Self::getAllClasseUE($annee);
		foreach($classeues as $classeue) {
			$newclasses = "";
			$classe = $classeue['idClasse'];
			$ids = explode(",", $classe);

			foreach($ids as $id) {

				if($id != $idClasse) { //Ajouter toutes les classes sauf celle à supprimer
					if(empty($newclasses))
						$newclasses .= $id;
					else
						$newclasses .= ",".$id;
				} 
			}

			if(empty($newclasses)) {
				(UE::read($classeue['idUE']))->delete();
			}
			$update = $bdd->prepare("UPDATE classe_ue SET idClasse=? WHERE idClasse='$classe' ");
			$update->execute(array($newclasses));
		}
	}

}