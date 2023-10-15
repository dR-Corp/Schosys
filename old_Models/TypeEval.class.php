<?php  

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
		}
		else{ print "Cet type d'evaluatiion existe déjà ";}		
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
			print "Type d'évaluation introuvable !";
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
			print "Modification échouée : risque de doublon. Cette codification de type d'évaluation est déjà utilisée !";
		}
		else {	
			$update = $bdd->prepare("UPDATE typeeval SET codeTypeEval=?, libelleTypeEval=? WHERE codeTypeEval='$codeTypeEval' ");
			$update->execute(array($newCodeTypeEval, $newLibTypeEval));

			print "Le type d'evaluation a été modifié avec succès";
		}	
	}

	public function delete() {

		$codeTypeEval = $this->codeTypeEval;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM typeeval WHERE codeTypeEval='$codeTypeEval' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Ce type d'évaluation n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM typeeval WHERE codeTypeEval='$codeTypeEval' ");

			print "Le type d'évaluations a été supprimé avec succès";
		}
	}

}