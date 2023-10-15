<?php
	if(!isset($_SESSION))
		session_start();

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

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : ce code de statut existe deja !';
		}

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
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : ce statut n\'existe pas !';
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
			
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : ce code statut existe deja !';
		}
		else {
			$update = $bdd->prepare("UPDATE statut SET codeStatut=?, libelleStatut=? WHERE codeStatut='$codeStatut' ");
			$update->execute(array($newCodeStatut, $newLibStatut));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}
	}

	public function delete() {

		$codeStatut = $this->codeStatut;
		include('../Database/database.php');
		include_once '../Models/Statut.class.php';

		$select = $bdd->query("SELECT * FROM statut WHERE codeStatut='$codeStatut' ");
		if(!empty($select) && $select->rowCount() == 0) {
			
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : ce code statut existe deja !';
		}
		else {
			$select2 = $bdd->query("SELECT * FROM etudiant WHERE codeStatut='$codeStatut' ");
			if(!empty($select2) && $select2->rowCount() == 0) {

				$delete = $bdd->exec("DELETE FROM statut WHERE codeStatut='$codeStatut' ");

				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
			}
			else {
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Suppression impossible : ce statut est déjà associé à des étudiants !';
			}
		}
	}

}