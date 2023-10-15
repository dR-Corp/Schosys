<?php  
	if(!isset($_SESSION))
		session_start();

class TypeEval {

	private $codeTypeEval;
	private $libTypeEval;

	function __construct($codeTypeEval,$libTypeEval){
		
		$this->codeTypeEval=$codeTypeEval;
		$this->libTypeEval=$libTypeEval;
	}

	public function getCodeTypeEval(){
		return $this->codeTypeEval;
	}
	public function setCodeTypeEval($newCodeTypeEval){
		if(!empty($newCodeTypeEval))
			$this->codeTypeEval = $newCodeTypeEval;
	}

	public function getLibTypeEval(){
		return $this->libTypeEval;
	}
	public function setLibTypeEval($newLibTypeEval){
		if(!empty($newLibTypeEval))
			$this->libTypeEval = $newLibTypeEval;
	}

	public static function create($codeTypeEval, $libTypeEval) {
		
		include_once('../Database/database.php');

		$request = $bdd->query(" SELECT * FROM typeeval WHERE codeTypeEval = '$codeTypeEval' ");

		if(!empty($request) && $request->rowCount() == 0 ){

			$insert = $bdd->prepare("INSERT INTO typeeval(codeTypeEval,libelleTypeEval) VALUES(?,?) ");
			$insert->execute(array($codeTypeEval,$libTypeEval));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';
		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : ce code de type d\'évaluation existe deja !';
		}		
	}

	public static function read($codeTypeEval) {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM typeeval WHERE codeTypeEval='$codeTypeEval' ");
		$aTypeEval = $select->fetchAll();
		if(!empty($aTypeEval)) {
			$typeeval = new TypeEval($aTypeEval[0][0], $aTypeEval[0][1]);
			return $typeeval;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : ce type d\'évaluation n\'existe pas !';
			return false;
		}

	}

	public static function getAllTypeEval() {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM typeeval ");
		$allTypeEval = $select->fetchAll();
		return $allTypeEval;
	}

	public function update($newCodeTypeEval, $newLibTypeEval) {

		$codeTypeEval = $this->codeTypeEval;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM typeeval WHERE codeTypeEval='$newCodeTypeEval' AND libelleTypeEval='$newLibTypeEval' ");
		if(!empty($select) && $select->rowCount() >=1) {
			
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : ce code de type d\'évaluation existe deja !';
		}
		else {	
			$update = $bdd->prepare("UPDATE typeeval SET codeTypeEval=?, libelleTypeEval=? WHERE codeTypeEval='$codeTypeEval' ");
			$update->execute(array($newCodeTypeEval, $newLibTypeEval));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}	
	}

	public function delete() {

		$codeTypeEval = $this->codeTypeEval;
		include('../Database/database.php');
		include_once '../Models/Evaluation.class.php';

		$select = $bdd->query("SELECT * FROM typeeval WHERE codeTypeEval='$codeTypeEval' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : ce code de type d\'évaluation existe deja !';
		}
		else {	

			$select2 = $bdd->query("SELECT * FROM evaluation WHERE codeTypeEval='$codeTypeEval' ");

			if(!empty($select2) && $select2->rowCount() == 0) {

				$delete = $bdd->exec("DELETE FROM typeeval WHERE codeTypeEval='$codeTypeEval' ");
				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
			}
			else {
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Suppression impossible : certaines évaluations sont déjà de ce type !';
			}
		}
	}

}