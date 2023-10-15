<?php
	if(!isset($_SESSION))
		session_start();

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

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';
		}
		else{
			print "Cette UE que vous avez entré existe déjà ";
		}
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
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : ce type d\UE n\'existe pas !';
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

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : ce code de type d\UE existe deja !';
		}
		else {	
			$update = $bdd->prepare("UPDATE typeue SET codeTypeUE=?, libelleTypeUE=? WHERE codeTypeUE='$codeTypeUE' ");
			$update->execute(array($newCodeTypeUE, $newLibTypeUE));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}	
	}

	public function delete() {

		$codeTypeUE = $this->codeTypeUE;
		include('../Database/database.php');
		include_once '../Models/UE.class.php';

		$select = $bdd->query("SELECT * FROM typeue WHERE codeTypeUE='$codeTypeUE' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : ce code de type d\'UE existe deja !';
		}
		else {	
			$select2 = $bdd->query("SELECT * FROM UE WHERE codeTypeUE='$codeTypeUE' ");

			if(!empty($select2) && $select2->rowCount() == 0) {

				$delete = $bdd->exec("DELETE FROM typeue WHERE codeTypeUE='$codeTypeUE' ");
				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
			}
			else {
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Suppression impossible : des UE de ce type existent déjà !';
			}
		}
	}

}