<?php 
class Evaluation {

	private $codeEval;
	private $libEval;
	private $dateEval;

	// Les clés etrangeres
	private $codeTypeEval; // le code du type de l'evaluation
	private $codeECU; // le code de l'ECU ayant fait l'objet d'evaluation

	function __construct($codeEval,$libEval,$dateEval,$codeTypeEval,$codeECU){

		$this->codeEval = $codeEval;
		$this->libEval = $libEval;
		$this->dateEval = $dateEval;
		$this->codeTypeEval = $codeTypeEval;
		$this->codeECU = $codeECU;

	}

	public function getCodeEval(){
		return $this->codeEval;
	}
	public function setCodeEval($newCodeEval){
		if(!empty($newCodeEval))
			$this->codeEval = $newCodeEval;
	}

	public function getLibEval(){
		return $this->libEval;
	}
	public function setLibEval($newLibEval){
		if(!empty($newLibEval))
			$this->libEval = $newLibEval;
	}

	public function getDateEval(){
		return $this->dateEval;
	}
	public function setDateEval($newDateEval){
		if(!empty($newDateEval))
			$this->dateEval = $newDateEval;
	}
	public function getCodeTypeEval() {
		return $this->codeTypeEval;
	}
	public function getCodeECU() {
		return $this->codeECU;
	}

	public static function create($codeEval, $libEval, $dateEval, $codeTypeEval, $codeECU) {
		
		include('../Database/database.php');
	
		$request1 = $bdd->query("SELECT * FROM typeeval");
		$request2 = $bdd->query("SELECT * FROM typeeval WHERE codeTypeEval='$codeTypeEval'");
		$request3 = $bdd->query("SELECT * FROM ecu");
		$request4 = $bdd->query("SELECT * FROM ecu WHERE codeECU='$codeECU'");
		$request5 = $bdd->query("SELECT * FROM evaluation WHERE codeEval='$codeEval'");
	
		if(!empty($request1) && $request1->rowCount() !=0){
	
			if(!empty($request2) && $request2->rowCount() ==1){
	
				if(!empty($request3) && $request3->rowCount() !=0){
	
					if(!empty($request4) && $request4->rowCount() ==1){
	
						if(!empty($request5) && $request5->rowCount() <1){
	
							$insert = $bdd->prepare("INSERT INTO evaluation(codeEval,libelleEval,codeECU,dateEval,codeTypeEval) VALUES(?,?,?,?,?)");
							$insert->execute(array($codeEval,$libEval,$codeECU,$dateEval,$codeTypeEval));
	
						}else{print "Cette evaluation existe deja";}
	
					}else{print "Le code de l'ecu specifie n'existe pas encore / cette ECU n'est pas pris en compte";}
	
				}else{print "Aucune ECU n'existe pour le moment";}
	
			}else{print "Le type d'evaluation specifie n'existe pas encore";}
	
		}else{print "Aucun type d'evaluation n'existe pour l'instant";}
		
	}

	public static function read($codeEval) {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM evaluation WHERE codeEval='$codeEval' ");
		$aEvaluation = $select->fetchAll();
		if(!empty($aEvaluation)) {
			$evaluation = new Evaluation($aEvaluation[0][0], $aEvaluation[0][1], $aEvaluation[0][2], $aEvaluation[0][4], $aEvaluation[0][3]);
			return $evaluation;
		}
		else {
			print "Evaluation introuvable !";
			return false;
		}
		
	}

	public static function getAllEvaluation() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM evaluation, ecu, typeeval WHERE evaluation.codeECU=ecu.codeECU AND evaluation.codeTypeEval=TypeEval.codeTypeEval ");
		$allEvaluation = $select->fetchAll();
		return $allEvaluation;
	}

	public function update($newCodeEval, $newLibEval, $newDateEval, $newCodeTypeEval, $newCodeECU) {

		$codeEval = $this->codeEval;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM evaluation WHERE codeEval='$newCodeEval' AND libelleEval=\"$newLibEval\" AND dateEval='$newDateEval' AND codeTypeEval='$newCodeTypeEval' AND codeECU='$newCodeECU' ");
		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée : risque de doublon. Cette codification d'évaluation est déjà utilisée !";
		}
		else {
			$update = $bdd->prepare("UPDATE evaluation SET codeEval=?, libelleEval=?, dateEval=?, codeTypeEval=?, codeECU=? WHERE codeEval='$codeEval' ");
			$update->execute(array($newCodeEval, $newLibEval, $newDateEval, $newCodeTypeEval, $newCodeECU));

			print "L'évaluation a été modifiée avec succès";
		}	
	}

	public function delete() {

		$codeEval = $this->codeEval;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM evaluation WHERE codeEval='$codeEval' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cette évaluation n'existe pas !";
		}
		else {
			$delete = $bdd->exec("DELETE FROM evaluation WHERE codeEval='$codeEval' ");

			print "L'évaluation a été supprimé";
		}
	}

	public static function findECU($codeECU) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM evaluation, obtenir WHERE codeECU='$codeECU' AND evaluation.codeEval=obtenir.codeEval");

		if(!empty($select) && $select->rowCount() == 0) {
			return false;
		}
		else {	
			return true;
		}

	}

	public static function getEvalNote($codeTypeEval, $codeECU, $matricule) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT note FROM evaluation, obtenir WHERE codeTypeEval='$codeTypeEval' AND codeECU='$codeECU' AND matricule='$matricule' AND evaluation.codeEval=obtenir.codeEval ");

		$eval = $select->fetchAll();
		if(!empty($eval)) {
			return $eval[0][0];
		}
		else {
			print "N/A";
			return false;
		}

	}

}









