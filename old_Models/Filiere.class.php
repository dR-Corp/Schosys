<?php

class Filiere {

	private $codeFiliere;
	private $libFiliere;

	function __construct($codeFiliere,$libFiliere) {
			
		$this->codeFiliere=$codeFiliere;
		$this->libFiliere=$libFiliere;

	}

	public function getCodeFiliere() {
		return $this->codeFiliere;
	}
	public function setCodeFiliere($newCodeFiliere) {
		if(!empty($newCodeFiliere))
			$this->codeFiliere = $newCodeFiliere;
	}

	public function getLibFiliere() {
		return $this->libFiliere;
	}
	public function setLibFiliere($newLibFiliere) {
		if(!empty($newLibFiliere))
			$this->libFiliere = $newLibFiliere;
	}

	public static function create($codeFiliere, $libFiliere) {
		
		include_once("../Database/database.php");
		$select = $bdd->query("SELECT * FROM filiere WHERE codeFiliere ='$codeFiliere'");

		if(!empty($select) && $select->rowCount()==0){

			$insert=$bdd->prepare("INSERT INTO filiere(codeFiliere,libelleFiliere) VALUES(?,?)");
			$insert->execute(array($codeFiliere,$libFiliere));

		}else{print "Cette filiere existe deja";}
		
	}

	public static function read($codeFiliere) {

		include('../Database/database.php');
		
		$select = $bdd->query("SELECT * FROM filiere WHERE codeFiliere='$codeFiliere' ");
		$aFiliere = $select->fetchAll();
		if(!empty($aFiliere)) {
			$filiere = new Filiere($aFiliere[0][0], $aFiliere[0][1]);
			return $filiere; 
		}
		else {
			print "Filière introuvable !";
			return false;
		}

	}

	public static function getAllFiliere() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM filiere ");
		$allFiliere = $select->fetchAll();
		return $allFiliere;
	}

	public function update($newCodeFiliere, $newLibFiliere) {

		$codeFiliere = $this->codeFiliere;
		include('../Database/database.php');
		
		$select = $bdd->query("SELECT * FROM filiere WHERE codeFiliere='$newCodeFiliere' ");
		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée : risque de doublon. Cette codification de filière est déjà utilisée !";
		}
		else {
			$update = $bdd->prepare("UPDATE filiere SET codeFiliere=?, libelleFiliere=? WHERE codeFiliere='$codeFiliere' ");
			$update->execute(array($newCodeFiliere, $newLibFiliere));

			print "La filière a été modifiée avec succès";
		}

	}

	public function delete() {

		$codeFiliere = $this->codeFiliere;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM filiere WHERE codeFiliere='$codeFiliere' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cette filière n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM filiere WHERE codeFiliere='$codeFiliere' ");

			print "La filière a été supprimée avec succès";
		}

	}

	public static function getNbFiliere() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM filiere");

		return $select->rowCount();
	}

}