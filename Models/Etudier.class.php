<?php

class Etudier {

	private $idClasse;
	private $idEtudiant;
	private $idAnnee;

	function __construct($idClasse,$idEtudiant,$idAnnee) {

		$this->idClasse=$idClasse;
		$this->idEtudiant=$idEtudiant;
		$this->idAnnee=$idAnnee;

	}

	public static function create($idClasse, $idEtudiant, $idAnnee) {

		include("../Database/database.php");

		$select = $bdd->query("SELECT * FROM etudier WHERE idClasse='$idClasse' AND idEtudiant='$idEtudiant'AND idAnnee='$idAnnee'");

		if(!empty($select) && $select->rowCount()==0){

			$insert=$bdd->prepare("INSERT INTO etudier(idClasse,idEtudiant,idAnnee) VALUES(?,?,?)");
			$insert->execute(array($idClasse,$idEtudiant,$idAnnee));

		}else{print "Risque de doublon; Cet enregistrement existe deja";}

	}
		
	public static function read($idClasse, $idEtudiant, $idAnnee) {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudier WHERE idClasse='$idClasse' AND idEtudiant='$idEtudiant' AND idAnnee='$idAnnee' ");
		$aEtudier = $select->fetchAll();
		if(!empty($aEtudier)) {
			$etudier = new Etudier($aEtudier[0][0], $aEtudier[0][1], $aEtudier[0][2]);
			return $etudier;
		}
		else {
			print "Cet étudiant n'est pas inscrit dans cette classe pour cette année académique !";
			return false;
		}
		
	}

	public static function getAllEtudier($annee) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudier WHERE idClasse LIKE '$annee%' AND idEtudiant LIKE '$annee%' AND idAnnee='$annee' ");
		$allEtudier = $select->fetchAll();
		return $allEtudier;
	}

	public function update($newidClasse, $idEtudiant, $idAnnee) {

		$idClasse = $this->idClasse;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudier WHERE idClasse='$idClasse' AND idEtudiant='$idEtudiant' AND idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Modification échouée. Cette étudier n'existe pas !";
		}
		else {
			$update = $bdd->prepare("UPDATE etudier SET idClasse=? WHERE idClasse='$idClasse' AND idEtudiant='$idEtudiant' AND idAnnee='$idAnnee' ");
			$update->execute(array($newidClasse));

			print "L'étudier a été modifié avec succès";
		}	
	}

	public function delete() {

		$idClasse = $this->idClasse;
		$idEtudiant = $this->idEtudiant;
		$idAnnee = $this->idAnnee;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudier WHERE idClasse='$idClasse' AND idEtudiant='$idEtudiant' AND idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cette étudier n'existe pas !";
		}
		else {
			$delete = $bdd->exec("DELETE FROM etudier WHERE idClasse='$idClasse' AND idEtudiant='$idEtudiant' AND idAnnee='$idAnnee' ");
			include_once '../Models/Etudiant.class.php';
			(Etudiant::read($idEtudiant))->delete();
			print "L'étude a été supprimé";
		}
	}

}