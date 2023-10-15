<?php
	if(!isset($_SESSION))
		session_start();

class Semestre {

	private $codeSemestre;
	private $libSemestre;

	function __construct($codeSemestre,$libSemestre) {
		
		$this->codeSemestre=$codeSemestre;
		$this->libSemestre=$libSemestre;

	}

	public function getCodeSemestre() {
		return $this->codeSemestre;
	}
	public function setCodeSemestre($newCodeSemestre) {
		if(!empty($newCodeSemestre))
			$this->codeSemestre = $newCodeSemestre;
	}

	public function getLibSemestre() {
		return $this->libSemestre;
	}
	public function setLibSemestre($newLibSemestre) {
		if(!empty($newLibSemestre))
			$this->libSemestre = $newLibSemestre;
	}

	public static function create($codeSemestre,$libSemestre) {
		
		include_once('../Database/database.php');
		$request = $bdd->query("SELECT * FROM semestre WHERE codeSemestre='$codeSemestre'");

		if(!empty($request) && $request->rowCount() == 0){

			$insert = $bdd->prepare("INSERT INTO semestre(codeSemestre,libelleSemestre) VALUES(?,?)");
			$insert->execute(array($codeSemestre,$libSemestre));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : ce code de semestre existe deja !';
		}

	}

	public static function read($codeSemestre) {
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM semestre WHERE codeSemestre='$codeSemestre' ");
		$aSemestre = $select->fetchAll();
		if(!empty($aSemestre)) {
			$semestre = new Semestre($aSemestre[0][0], $aSemestre[0][1]);
			return $semestre;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : ce semestre n\'existe pas !';
			return false;
		}
	}

	public static function getAllSemestre() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM semestre ");
		$allSemestre = $select->fetchAll();
		return $allSemestre;
	}

	public function update($newCodeSemestre, $newLibSemestre) {

		$codeSemestre = $this->codeSemestre;
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM semestre WHERE codeSemestre='$newCodeSemestre' AND libelleSemestre='$newLibSemestre' ");

		if(!empty($select) && $select->rowCount() >=1) {
			
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : ce code semestre existe deja !';
		}
		else {
			$update = $bdd->prepare("UPDATE semestre SET codeSemestre=?, libelleSemestre=? WHERE codeSemestre='$codeSemestre' ");
			$update->execute(array($newCodeSemestre, $newLibSemestre));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}
	}

	public function delete() {

		$codeSemestre = $this->codeSemestre;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM semestre WHERE codeSemestre='$codeSemestre' ");
		if(!empty($select) && $select->rowCount() == 0) {
			
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : ce code semestre existe deja !';
		}
		else {
			$select2 = $bdd->query("SELECT * FROM ue WHERE codeSemestre='$codeSemestre' ");
			if(!empty($select2) && $select2->rowCount() == 0) {

				$delete = $bdd->exec("DELETE FROM semestre WHERE codeSemestre='$codeSemestre' ");

				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
			}
			else {
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Suppression impossible : ce semestre est déjà associé à des UE !';
			}
		}
	}

}