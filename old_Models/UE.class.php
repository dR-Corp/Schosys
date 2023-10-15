<?php

class UE {
	private $codeUE; // le code de l'UE
	private $libUE; // libellé de l'UE
	private $coefUE; // coefficient de l'UE

	//clé etrangere
	private $codeTypeUE; // le code du type de l'UE

	function __construct($codeUE,$libUE,$coefUE,$codeTypeUE) {

		$this->codeUE = $codeUE;
		$this->libUE = $libUE;
		$this->coefUE = $coefUE;
		$this->codeTypeUE = $codeTypeUE;

	}

	public function getCodeUE(){
	 	return $this->codeUE;
	}
	public function setCodeUE($newCodeUE){
	 	if(!empty($newCodeUE))
	 	 	$this->codeUE = $newCodeUE;
	}


	public function getLibUE(){
		return $this->libUE;
	}
	public function setLibUE($newLibUE){
	 	if(!empty($newLibUE))
	 	 	$this->libUE = $newLibUE;
	}

	public function getCoefUE(){
	 	return $this->coefUE;
	}
	public function setCoefUE($newCoefUE){
	 	if(!empty($newCoefUE))
	 	 	$this->coefUE = $newCoefUE;
	}

	public static function create($codeUE, $libUE, $coefUE, $codeTypeUE) {
		
		include_once('../Database/database.php');

		$request1 = $bdd->query("SELECT * FROM typeue");
		
		if(!empty($request1) && $request1->rowCount() == 0){
			print "Aucun type d'UE n'existe, veuillez en rajouter avant de poursuivre";
		} 
		else{
			$request2 = $bdd->query("SELECT * FROM typeue WHERE codeTypeUE='$codeTypeUE'");
			
			$request3 = $bdd->prepare("SELECT * FROM ue WHERE codeUE=? AND libelleUE=?");
			$request3->execute(array($codeUE, $libUE));
		
			if(!empty($request2) && $request2->rowCount() == 1){

				if(!empty($request3) && $request3->rowCount() == 0){
					
					$insertion = $bdd->prepare('INSERT INTO ue(codeUE, libelleUE, coef, codeTypeUE) VALUES(?, ?, ?, ?)');
					$insertion->execute(array($codeUE, $libUE, $coefUE, $codeTypeUE));
				}else{ print "Cette UE existe deja"; }
			}
			else{print "Ce type d'UE n'existe pas dans la liste";}
		}
	}

	public static function read($codeUE) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue WHERE codeUE='$codeUE' ");
		$aUE = $select->fetchAll();
		if(!empty($aUE)) {
			$ue = new UE($aUE[0][0], $aUE[0][1], $aUE[0][2], $aUE[0][3]);
			return $ue;
		}
		else {
			print "UE introuvable !";
			return false;
		}
			
	}

	public static function getAllUE() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue, classe_ue WHERE ue.codeUE=classe_ue.codeUE ");
		$allUE = $select->fetchAll();
		return $allUE;
	}

	public function update($newCodeUE, $newLibUE, $newCoefUE, $newCodeTypeUE) {

		$codeUE = $this->codeUE;
		include('../Database/database.php');

		$select = $bdd->prepare("SELECT * FROM ue WHERE codeUE=? AND libelleUE=? AND coef=? AND codeTypeUE=? ");
		$select->execute(array($newCodeUE, $newLibUE, $newCoefUE, $newCodeTypeUE));
		if(!empty($select) && $select->rowCount() >= 1) {
			print "Modification échouée. Cette unité d'enseignement existe  déjà!";
		}
		else {
			$update = $bdd->prepare("UPDATE ue SET codeUE=?, libelleUE=?, coef=?, codeTypeUE=? WHERE codeUE='$codeUE' ");
			$update->execute(array($newCodeUE, $newLibUE, $newCoefUE, $newCodeTypeUE));

			print "L'unité d'enseignement a été modifié avec succès";
		}
	}

	public function delete() {

		$codeUE = $this->codeUE;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue WHERE codeUE='$codeUE' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cette unité d'enseignement n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM ue WHERE codeUE='$codeUE' ");

			print "L'unité d'enseignement a été supprimé";
		}
	}

}