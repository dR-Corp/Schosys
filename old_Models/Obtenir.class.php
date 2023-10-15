<?php

class Obtenir {

	private $note;
	private $matriculeEtu;
	private $codeEval;

	function __construct($codeEval,$matriculeEtu,$note) {
		
		$this->codeEval=$codeEval;
		$this->matriculeEtu=$matriculeEtu;
		$this->note=$note;

	}

	public function getNote() {
		return $this->note;
	}
	public function setNote($newNote) {
		if(!empty($newNote))
			$this->note = $newNote;
	}

	public static function create($codeEval, $matriculeEtu, $note) {
		
		include("../Database/database.php");

		$select=$bdd->query("SELECT note FROM obtenir WHERE matricule='$matriculeEtu' AND codeEval='$codeEval'");

		if(!empty($select) && $select->rowCount()==0){

			$insert=$bdd->prepare("INSERT INTO obtenir(codeEval,matricule,note) VALUES(?,?,?)");
			$insert->execute(array($codeEval,$matriculeEtu,$note));

		}else{print "Cet etudiant a deja une note pour cette ecu";}
		
	}

	public static function read($codeEval, $matriculeEtu) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE codeEval='$codeEval' AND matricule='$matriculeEtu' ");
		$aObtenir = $select->fetchAll();
		if(!empty($aObtenir)) {
			$obtenir = new Obtenir($aObtenir[0][0], $aObtenir[0][1], $aObtenir[0][2]);
			return $obtenir;
		}
		else {
			return false;
		}
	}

	public static function getallobtenir() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir ");
		$allObtenir = $select->fetchAll();
		return $allObtenir;
	}

	public function update($note) {

		$codeEval = $this->codeEval;
		$matriculeEtu = $this->matriculeEtu;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE codeEval='$codeEval' AND matricule='$matriculeEtu' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Modification échouée. Cette obtenir n'existe pas !";
		}
		else {	
			$update = $bdd->prepare("UPDATE obtenir SET note=? WHERE codeEval='$codeEval' AND matricule='$matriculeEtu' ");
			$update->execute(array($note));

			print "L'obtenir a été modifié avec succès";
		}	
	}

	public function delete() {

		$codeEval = $this->codeEval;
		$matriculeEtu = $this->matriculeEtu;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE codeEval='$codeEval' AND matricule='$matriculeEtu' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cette obtenir n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM obtenir WHERE codeEval='$codeEval' AND matricule='$matriculeEtu' ");

			print "L'obtenir a été supprimé";
		}
	}

	public static function findEval($codeEval) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE codeEval='$codeEval'");

		if(!empty($select) && $select->rowCount() == 0) {
			return false;
		}
		else {	
			return true;
		}

	}

}