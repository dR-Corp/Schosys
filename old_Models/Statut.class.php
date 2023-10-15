<?php

class Statut {

	private $codeStatut;
	private $libStatut;

	function __construct($codeStatut,$libStatut) {
		
		$this->codeStatut=$codeStatut;
		$this->libStatut=$libStatut;

	}

	public function getCodeStatut() {
		return $this->codeStatut;
	}
	public function setCodeStatut($newCodeStatut) {
		if(!empty($newCodeStatut))
			$this->codeStatut = $newCodeStatut;
	}

	public function getLibStatut() {
		return $this->libStatut;
	}
	public function setLibStatut($newLibStatut) {
		if(!empty($newLibStatut))
			$this->libStatut = $newLibStatut;
	}

	public static function create($codeStatut, $libStatut) {
		
		include_once('../Database/database.php');
		$request = $bdd->query("SELECT * FROM statut WHERE codeStatut='$codeStatut'");

		if(!empty($request) && $request->rowCount() == 0){

			$insert = $bdd->prepare("INSERT INTO statut(codeStatut,libelleStatut) VALUES(?,?)");
			$insert->execute(array($codeStatut,$libStatut));

		}else{ print "Ce code Statut d'etudiant existe deja";}

	}

	public static function read($codeStatut) {
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM statut WHERE codeStatut='$codeStatut' ");
		$aStatut = $select->fetchAll();
		if(!empty($aStatut)) {
			$statut = new Statut($aStatut[0][0], $aStatut[0][1]);
			return $statut;
		}
		else {
			print "Statut introuvable !";
			return false;
		}
	}

	public static function getAllStatut() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM statut ");
		$allStatut = $select->fetchAll();
		return $allStatut;
	}

	public function update($newCodeStatut, $newLibStatut) {

		$codeStatut = $this->codeStatut;
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM statut WHERE codeStatut='$newCodeStatut' AND libelleStatut='$newLibStatut' ");

		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée : risque de doublon. Cette codification de statut est déjà utilisée !";
		}
		else {
			$update = $bdd->prepare("UPDATE statut SET codeStatut=?, libelleStatut=? WHERE codeStatut='$codeStatut' ");
			$update->execute(array($newCodeStatut, $newLibStatut));

			print "Le statut a été modifié avec succès";
		}
	}

	public function delete() {

		$codeStatut = $this->codeStatut;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM statut WHERE codeStatut='$codeStatut' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Ce statut n'existe pas !";
		}
		else {
			$delete = $bdd->exec("DELETE FROM statut WHERE codeStatut='$codeStatut' ");

			print "Le statut a été supprimé avec succès";
		}
	}

}