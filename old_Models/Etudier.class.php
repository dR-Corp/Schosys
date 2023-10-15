<?php

class Etudier {

	private $codeClasse;
	private $matriculeEtu;
	private $idAnnee;

	function __construct($codeClasse,$matriculeEtu,$idAnnee) {

		$this->codeClasse=$codeClasse;
		$this->matriculeEtu=$matriculeEtu;
		$this->idAnnee=$idAnnee;

	}

	public static function create($codeClasse, $matriculeEtu, $idAnnee) {

		include("../Database/database.php");

		$select1 = $bdd->query("SELECT * FROM etudiant WHERE matricule='$matriculeEtu'");
		$select2 = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee'");
		$select3 = $bdd->query("SELECT * FROM classe WHERE codeClasse='$codeClasse'");
		$select4 = $bdd->query("SELECT * FROM etudier WHERE codeClasse='$codeClasse' AND matricule='$matriculeEtu'AND idAnnee='$idAnnee'");

		if(!empty($select1) && $select1->rowCount()==1){

			if(!empty($select2) && $select2->rowCount()==1){

				if(!empty($select3) && $select3->rowCount()==1){

					if(!empty($select4) && $select4->rowCount()==0){

						$insert=$bdd->prepare("INSERT INTO etudier(codeClasse,matricule,idAnnee) VALUES(?,?,?)");
						$insert->execute(array($codeClasse,$matriculeEtu,$idAnnee));

					}else{print "Risque de doublon; Cet enregistrement existe deja";}

				}else{print "La classe que vous avez entre n'existe pas !";}

			}else{print "L'annee academique que vous avez entre n'existe pas !";}

		}else{print "Cet etudiant n'existe pas !";}
	}
		
	public static function read($codeClasse, $matriculeEtu, $idAnnee) {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudier WHERE codeClasse='$codeClasse' AND matricule='$matriculeEtu' AND idAnnee='$idAnnee' ");
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

	public static function getAllEtudier() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudier ");
		$allEtudier = $select->fetchAll();
		return $allEtudier;
	}

	public function update($newCodeClasse, $matriculeEtu, $idAnnee) {

		$codeClasse = $this->codeClasse;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudier WHERE codeClasse='$codeClasse' AND matricule='$matriculeEtu' AND idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Modification échouée. Cette étudier n'existe pas !";
		}
		else {
			$update = $bdd->prepare("UPDATE etudier SET codeClasse=? WHERE codeClasse='$codeClasse' AND matricule='$matriculeEtu' AND idAnnee='$idAnnee' ");
			$update->execute(array($newCodeClasse));

			print "L'étudier a été modifié avec succès";
		}	
	}

	public function delete() {

		$codeClasse = $this->codeClasse;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudier WHERE codeClasse='$codeClasse' AND matricule='$matriculeEtu' AND idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cette étudier n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM etudier WHERE codeClasse='$codeClasse' AND matricule='$matriculeEtu' AND idAnnee='$idAnnee' ");

			print "L'étudier a été supprimé";
		}
	}

}