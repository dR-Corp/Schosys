<?php

class Niveau {

	private $codeNiveau;
	private $libNiveau;

	function __construct($codeNiveau,$libNiveau) {
			
		$this->codeNiveau=$codeNiveau;
		$this->libNiveau=$libNiveau;

	}

	public function getCodeNiveau() {
		return $this->codeNiveau;
	}
	public function setCodeNiveau($newCodeNiveau) {
		if(!empty($newCodeNiveau))
			$this->codeNiveau = $newCodeNiveau;
	}

	public function getLibNiveau() {
		return $this->libNiveau;
	}
	public function setLibNiveau($newLibNiveau) {
		if(!empty($newLibNiveau))
			$this->libNiveau = $newLibNiveau;
	}

	public static function create($codeNiveau, $libNiveau) {
		
		include_once("../Database/database.php");

		$select = $bdd->query("SELECT * FROM niveau WHERE codeNiveau ='$codeNiveau'");
	
		if(!empty($select) && $select->rowCount()==0){

			$insert=$bdd->prepare("INSERT INTO niveau(codeNiveau,libelleNiveau) VALUES(?,?)");
			$insert->execute(array($codeNiveau,$libNiveau));

		}else{print "Ce niveau existe deja";}
		
	}

	public static function read($codeNiveau) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM niveau WHERE codeNiveau='$codeNiveau' ");
		$aNiveau = $select->fetchAll();
		if(!empty($aNiveau)) {
			$niveau = new Niveau($aNiveau[0][0], $aNiveau[0][1]);
			return $niveau;
		}
		else {
			print "Niveau introuvable !";
			return false;
		}
	}

	public static function getAllNiveau() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM niveau ");
		$allNiveau = $select->fetchAll();
		return $allNiveau;
	}

	public function update($newCodeNiveau, $newLibNiveau) {

		$codeNiveau = $this->codeNiveau;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM niveau WHERE codeNiveau='$newCodeNiveau' AND libelleNiveau='$newLibNiveau' ");
		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée : risque de doublon. Cette codification de niveau est déjà utilisée !";
		}
		else {	
			$update = $bdd->prepare("UPDATE niveau SET codeNiveau=?, libelleNiveau=? WHERE codeNiveau='$codeNiveau' ");
			$update->execute(array($newCodeNiveau, $newLibNiveau));

			print "Le niveau a été modifié avec succès";
		}	
	}

	public function delete() {

		$codeNiveau = $this->codeNiveau;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM niveau WHERE codeNiveau='$codeNiveau' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Ce niveau n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM niveau WHERE codeNiveau='$codeNiveau' ");

			print "Le type d'unité d'enseignement a été supprimé avec succès";
		}
	}

	public static function getNbNiveau() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM niveau");

		return $select->rowCount();
	}

}