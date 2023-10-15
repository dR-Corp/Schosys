<?php

class AnneeAcademique {

	private $idAnnee;
	private $annee;

	function __construct($idAnnee,$annee) {
		$this->idAnnee=$idAnnee;
		$this->annee=$annee;
	}

	public function getIdAnnee() {
		return $this->idAnnee;
	}
	public function setIdAnnee($newIdAnnee) {
		if(!empty($newIdAnnee))
			$this->idAnnee = $newIdAnnee;
	}

	public function getAnnee() {
		return $this->annee;
	}
	public function setAnnee($newAnnee) {
		if(!empty($newAnnee))
			$this->annee = $newAnnee;
	}

	public static function create($idAnnee, $annee) {
		
		include_once("../Database/database.php");

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee'");

		if(!empty($select) && $select->rowCount()==0){

			$insert=$bdd->prepare("INSERT INTO anneeacad(idAnnee,annee) VALUES(?,?)");
			$insert->execute(array($idAnnee,$annee));
		}else{print "Cette annee existe deja";}
		
	}

	public static function read($idAnnee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee' ");
		$aAnneeAcad = $select->fetchAll();
		if(!empty($aAnneeAcad)) {
			$annee = new AnneeAcademique($aAnneeAcad[0][0], $aAnneeAcad[0][1]);
			return $annee;
		}
		else {
			print "Année academique introuvable !";
			return false;
		}
	}

	public static function getAllAnneeAcademique() {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM anneeacad ");
		$allAnneeAcad = $select->fetchAll();
		return $allAnneeAcad;
	}

	public function update($newIdAnnee, $newAnnee) {
		$idAnnee = $this->idAnnee;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$newIdAnnee' ");
		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée. Cette année académique existe déjà !";
		}
		else {
			$update = $bdd->prepare("UPDATE anneeacad SET idAnnee=?, annee=? WHERE idAnnee='$idAnnee' ");
			$update->execute(array($newIdAnnee, $newAnnee));

			print "L'année acdémique a été modifié avec succès";
		}	
	}

	public function delete() {
		$idAnnee = $this->idAnnee;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cette année académique n'existe pas !";
		}
		else {
			$delete = $bdd->exec("DELETE FROM anneeacad WHERE idAnnee='$idAnnee' ");

			print "L'année académique a été supprimé avec succès";
		}
	}

	public static function encours() {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM anneeacad WHERE encours=1");
		if(!empty($select) && $select->rowCount() > 0) {

			$aAnneeAcad = $select->fetchAll();
			$annee = new AnneeAcademique($aAnneeAcad[0][0], $aAnneeAcad[0][1]);
			return $annee;
		}
		else {
			return false;
		}

	}

	public static function en_cours() {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM anneeacad WHERE encours=1");
		if(!empty($select) && $select->rowCount() > 0) {
			return true;
		}
		else {
			return false;
		}

	}

	public function start() {

		$idAnnee = $this->idAnnee;
		include('../Database/database.php');
		
		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Cette année académique n'existe pas !";
		}
		else {

			if(self::encours()) {
				print "<script>alert(\"Il y a déjà une année academique en cours\")</script>";
			}
			else {
				$update = $bdd->exec("UPDATE anneeacad SET encours=1 WHERE idAnnee='$idAnnee' ");
				print "<script>alert(\"L'année académique a commencé\")</script>";
			}

			
		}

	}

	public function end() {

		$idAnnee = $this->idAnnee;
		include('../Database/database.php');
		
		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Cette année académique n'existe pas !";
		}
		else {

			if(!self::encours()) {
				print "<script>alert(\"Cette année academique n'est pas en cours\")</script>";
			}
			else {
				$update = $bdd->exec("UPDATE anneeacad SET encours=0 WHERE idAnnee='$idAnnee' ");
				print "<script>alert(\"L'année académique est terminée\")</script>";
			}


		}

	}

}