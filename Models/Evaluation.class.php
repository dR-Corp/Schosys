<?php 
	if(!isset($_SESSION))
		session_start();
class Evaluation {

	private $idEvaluation;
	private $codeEval;
	private $libEval;

	// Les clés etrangeres
	private $codeTypeEval; // le code du type de l'evaluation
	private $idECU; // le code de l'ECU ayant fait l'objet d'evaluation

	function __construct($idEvaluation,$codeEval,$libEval,$codeTypeEval,$idECU){

		$this->idEvaluation = $idEvaluation;
		$this->codeEval = $codeEval;
		$this->codeEval = $codeEval;
		$this->libEval = $libEval;
		$this->codeTypeEval = $codeTypeEval;
		$this->idECU = $idECU;

	}

	public function getIdEvaluation(){
		return $this->idEvaluation;
	}
	public function setIdEvaluation($newIdEvaluation){
		if(!empty($newIdEvaluation))
			$this->idEvaluation = $newIdEvaluation;
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

	public function getCodeTypeEval() {
		return $this->codeTypeEval;
	}
	public function getIdECU() {
		return $this->idECU;
	}

	public static function create($idEvaluation, $codeEval, $libEval, $codeTypeEval, $idECU) {
		
		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$request5 = $bdd->query("SELECT * FROM evaluation WHERE idEvaluation LIKE '$encours%' AND codeEval='$codeEval'");
	
		if(!empty($request5) && $request5->rowCount() == 0){

			$insert = $bdd->prepare("INSERT INTO evaluation(idEvaluation,codeEval,libelleEval,idECU,codeTypeEval) VALUES(?,?,?,?,?)");
			$insert->execute(array($idEvaluation, $codeEval, $libEval, $idECU, $codeTypeEval));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : cette évaluation existe déjà !';
		}
					
	}

	public static function read($idEvaluation) {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM evaluation WHERE idEvaluation='$idEvaluation' ");
		$aEvaluation = $select->fetchAll();
		if(!empty($aEvaluation)) {
			$evaluation = new Evaluation($aEvaluation[0][0], $aEvaluation[0][1], $aEvaluation[0][2], $aEvaluation[0][4], $aEvaluation[0][3]);
			return $evaluation;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cette évaluation n\'existe pas  !';
			return false;
		}
		
	}

	public static function getAllEvaluation($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM evaluation, ecu, typeeval WHERE evaluation.idECU=ecu.idECU AND evaluation.codeTypeEval=TypeEval.codeTypeEval AND idEvaluation LIKE '$annee%' ");
		$allEvaluation = $select->fetchAll();
		return $allEvaluation;
	}

	public static function getTypeEvalECUEval($idECU, $codeTypeEval) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM evaluation WHERE idECU='$idECU' AND codeTypeEval='$codeTypeEval' ");
		$allEvaluation = $select->fetchAll();
		return $allEvaluation[0][0];
	}

	public function update($newCodeEval, $newLibEval, $newCodeTypeEval, $newIdECU) {
		
		$idEvaluation = $this->idEvaluation;
		$codeEval = $this->codeEval;
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();
		$select = $bdd->query("SELECT * FROM evaluation WHERE idEvaluation LIKE '$encours%' AND codeEval='$newCodeEval'");
		
		if($codeEval != $newCodeEval && !empty($select) && $select->rowCount() > 0) {
			
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : cette évaluation existe déjà !';
		}
		else {
			
			$update = $bdd->prepare("UPDATE evaluation SET codeEval=?, libelleEval=?, codeTypeEval=?, idECU=? WHERE idEvaluation='$idEvaluation' ");
			$update->execute(array($newCodeEval, $newLibEval, $newCodeTypeEval, $newIdECU));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}	
	}

	public function delete() {

		$idEvaluation = $this->idEvaluation;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM evaluation WHERE idEvaluation='$idEvaluation' ");
		if(!empty($select) && $select->rowCount() == 0) {
			
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : cette évaluation n\'existe pas !';
		}
		else {
			$delete = $bdd->exec("DELETE FROM evaluation WHERE idEvaluation='$idEvaluation' ");

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
		}
	}

	public static function findECU($idECU) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM evaluation, obtenir WHERE idECU='$idECU' AND evaluation.idEvaluation=obtenir.idEvaluation");

		if(!empty($select) && $select->rowCount() == 0) {
			return false;
		}
		else {	
			return true;
		}

	}

	public static function getEvalNote($codeTypeEval, $idECU, $idEtudiant) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT note FROM evaluation, obtenir WHERE codeTypeEval='$codeTypeEval' AND idECU='$idECU' AND idEtudiant='$idEtudiant' AND evaluation.idEvaluation=obtenir.idEvaluation ");

		$eval = $select->fetchAll();
		if(!empty($eval)) {
			return $eval[0][0];
		}
		else {
			//print "N/A";  //La ligne est retirée pour éviter les affichages qu'elle engendrait
			return false;
		}

	}

	public static function genererIdEvaluation() {

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();

		$select = $bdd->query("SELECT * FROM evaluation");

		if(!empty($select) && $select->rowCount() == 0){
			$idEvaluation = ($encours)->getIdAnnee() .'-1';
		}
		else {

			$evaluations = Evaluation::getAllEvaluation($encours->getIdAnnee());

			foreach($evaluations as $evaluation) {
				$evalId[] =  (explode("-", $evaluation['idEvaluation']))[1] ;
			}
			$max = $evalId[0];
			
			for($i = 1; $i < count($evalId); $i++) {
				if($evalId[$i] > $max) {
					$max = $evalId[$i];
				}
			}
			$a = $max+1;
			$idEvaluation = $encours->getIdAnnee() .'-'.$a;
		}
		
		return $idEvaluation;
	}

}









