<?php

class Classe {

	private $codeClasse;
	private $libClasse;

	//Clés étrangères
	private $codeNiveau;
	private $codeFiliere;

	function __construct($codeClasse,$libClasse,$codeNiveau,$codeFiliere) {

		$this->codeClasse = $codeClasse;
		$this->libClasse = $libClasse;
		$this->codeNiveau = $codeNiveau;
		$this->codeFiliere = $codeFiliere;

	}

	public function getCodeClasse() {
		return $this->codeClasse;
	}
	public function setCodeClasse($newCodeClasse) {
		if(!empty($newCodeClasse))
			$this->codeClasse = $newCodeClasse;
	}

	public function getLibClasse() {
		return $this->libClasse;
	}
	
	public function setLibClasse($newLibClasse) {
		if(!empty($newLibClasse))
			$this->libClasse = $newLibClasse;
	}
	public function getCodeFiliere() {
		return $this->codeFiliere;
	}
	public function getCodeNiveau() {
		return $this->codeNiveau;
	}

	public static function create($codeClasse, $libClasse, $codeNiveau, $codeFiliere) {
		
		include("../Database/database.php");
		
		$select1 = $bdd->query("SELECT * FROM niveau WHERE codeNiveau='$codeNiveau'");
		$select2 = $bdd->query("SELECT * FROM filiere WHERE codeFiliere='$codeFiliere'");
		$select3 = $bdd->query("SELECT * FROM classe WHERE codeClasse='$codeClasse'");
		
		if(!empty($select1) && $select1->rowCount()>=1){

			if(!empty($select2) && $select2->rowCount()>=1){

				if(!empty($select3) && $select3->rowCount()==0){

					$insert = $bdd->prepare("INSERT INTO classe(codeClasse,libelleClasse,codeNiveau,codeFiliere) VALUES(?,?,?,?)");
					$insert->execute(array($codeClasse,$libClasse,$codeNiveau,$codeFiliere));

				}else{print "Cette classe existe deja";}

			}else{print "Cette filiere n'existe pas; Veuillez fournir une entree valide.";}

		}else{print " Ce niveau n'est pas pris en compte; Veuillez vous assurer d'entrer un niveau disponible.";}

	}

	public static function read($codeClasse) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe WHERE codeClasse='$codeClasse' ");
		$aClasse = $select->fetchAll();
		if(!empty($aClasse)) {
			$classe = new Classe($aClasse[0][0], $aClasse[0][1],$aClasse[0][2], $aClasse[0][3] );
			return $classe;
		}
		else {
			print "Classe introuvable !";
			return false;
		}
	}

	public static function getAllClasse() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe ");
		$allClasse = $select->fetchAll();
		return $allClasse;
	}

	public function update($newCodeClasse, $newLibClasse, $newCodeNiveau, $newCodeFiliere) {

		$codeClasse = $this->codeClasse;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe WHERE codeClasse='$newCodeClasse' AND libelleClasse='$newLibClasse' AND codeNiveau='$newCodeNiveau' AND codeFiliere='$newCodeFiliere' ");
		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée. Cette classe existe déjà !";
		}
		else {	
			$update = $bdd->prepare("UPDATE classe SET codeClasse=?, libelleClasse=?, codeNiveau=?, codeFiliere=? WHERE codeClasse='$codeClasse' ");
			$update->execute(array($newCodeClasse, $newLibClasse, $newCodeNiveau, $newCodeFiliere));

			print "La classe a été modifiée avec succès";
		}	
	}

	public function delete() {

		$codeClasse = $this->codeClasse;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe WHERE codeClasse='$codeClasse' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cette classe n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM classe WHERE codeClasse='$codeClasse' ");

			print "La classe a été supprimé avec succès";
		}
	}

	public static function getNbClasse() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe");

		return $select->rowCount();
	}

}