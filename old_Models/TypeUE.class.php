<?php

class TypeUE {

	private $codeTypeUE;
	private $libTypeUE;

	function __construct($codeTypeUE,$libTypeUE) {

		$this->codeTypeUE=$codeTypeUE;
		$this->libTypeUE=$libTypeUE;

	}

	public function getCodeTypeUE() {
		return $this->codeTypeUE;
	}
	public function setCodeTypeUE($newCodeTypeUE) {
		if(!empty($newCodeTypeUE))
			$this->codeTypeUE = $newCodeTypeUE;
	}

	public function getLibTypeUE() {
		return $this->libTypeUE;
	}
	public function setLibTypeUE($newLibTypeUE) {
		if(!empty($newlibTypeUE))
			$this->libTypeUE = $newLibTypeUE;
	}

	public static function create($codeTypeUE, $libTypeUE) {
		
		include_once('../Database/database.php');

		$request = $bdd->query(" SELECT * FROM typeue WHERE codeTypeUE = '$codeTypeUE' ");

		if(!empty($request) && $request->rowCount() == 0 ){
			$insert = $bdd->prepare("INSERT INTO typeue(codeTypeUE,libelleTypeUE) VALUES(?,?) ");
			$insert->execute(array($codeTypeUE,$libTypeUE));
		}
		else{ print "Cette UE que vous avez entré existe déjà ";}
	}

	public static function read($codeTypeUE) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM typeue WHERE codeTypeUE='$codeTypeUE' ");
		$aTypeUE = $select->fetchAll();
		if(!empty($aTypeUE)) {
			$typeue = new TypeUE($aTypeUE[0][0], $aTypeUE[0][1]);
			return $typeue;
		}
		else {
			print "Type d'UE introuvable !";
			return false;
		}

	}

	public static function getAllTypeUE() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM typeue ");
		$allTypeUE = $select->fetchAll();
		return $allTypeUE;
	}

	public function update($newCodeTypeUE, $newLibTypeUE) {

		$codeTypeUE = $this->codeTypeUE;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM typeue WHERE codeTypeUE='$newCodeTypeUE' AND libelleTypeUE='$newLibTypeUE' ");
		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée : risque de doublon. Cette codification de type d'unité d'enseignement est déjà utilisée !";
		}
		else {	
			$update = $bdd->prepare("UPDATE typeue SET codeTypeUE=?, libelleTypeUE=? WHERE codeTypeUE='$codeTypeUE' ");
			$update->execute(array($newCodeTypeUE, $newLibTypeUE));

			print "Le type d'unité d'enseignement a été modifié avec succès";
		}	
	}

	public function delete() {

		$codeTypeUE = $this->codeTypeUE;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM typeue WHERE codeTypeUE='$codeTypeUE' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Ce type d'unité d'enseignement n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM typeue WHERE codeTypeUE='$codeTypeUE' ");

			print "Le type d'unité d'enseignement a été supprimé avec succès";
		}
	}

}