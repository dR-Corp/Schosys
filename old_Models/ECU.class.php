<?php

class ECU {

	private $codeECU; // code de l'ECU
	private $libECU; // libellé de l'ECU

	// clé etrangere
	private $codeUE; // code de l'UE auquel appartient l'ECU

	function __construct($codeECU,$libECU,$codeUE){

		$this->codeECU=$codeECU;
		$this->libECU=$libECU;
		$this->codeUE=$codeUE;

	}

	public function getCodeECU(){
		return $this->codeECU;
	}
	public function setCodeECU($newCodeECU){
		if(!empty($newCodeECU))
			$this->codeECU = $newCodeECU;
	}

	public function getLibECU(){
		return $this->libECU;
	}
	public function setLibECU($newLibECU){
		if(!empty($newLibECU))
			$this->libECU = $newLibECU;
	}
	public function getCodeUE(){
		return $this->codeUE;
	}

	public static function create($codeECU, $libECU, $codeUE) {
		
		include_once('../Database/database.php');
		$request = $bdd->query("SELECT * FROM ue WHERE codeUE='$codeUE'");
		$request1 = $bdd->query("SELECT * FROM ecu WHERE codeECU='$codeECU'");
		$request2 = $bdd->query("SELECT * FROM ue");
	
		if(!empty($request2) && $request2->rowCount()>=1){
			if(!empty($request) && $request->rowCount()>= 1){
				if(!empty($request1) && $request1->rowCount()== 0){
	
					$insert =$bdd->prepare("INSERT INTO ecu(codeEcu,libelleEcu,codeUE) VALUES(?,?,?)");
					$insert->execute(array($codeECU,$libECU,$codeUE));
	
				}else{ print "Cette ECU existe deja";}
			}else{print "l'UE spécifiée n'existe pas encore";}
		}else{print "Aucune UE n'existe pour le moment";}
		
	}

	public static function read($codeECU) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu WHERE codeECU='$codeECU' ");
		$aECU = $select->fetchAll();

		if (!empty($aECU)) {
			$ecu = new ECU($aECU[0][0], $aECU[0][1],$aECU[0][2]);
			return $ecu;
		}
		else{
			print "ECU introuvable !";
			  return false;}
	}

	public static function getAllECU() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu ");
		$allECU = $select->fetchAll();
		return $allECU;
	}

	
	public static function getUEECU($codeUE) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu WHERE codeUE='$codeUE'");
		$allUEECU = $select->fetchAll();
		return $allUEECU;
	}

	public static function getUEECUNumber($codeUE) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu WHERE codeUE='$codeUE'");
		return $select->rowCount();
	}

	public function update($newCodeECU, $newLibECU, $newCodeUE) {

		$codeECU = $this->codeECU;
		include('../Database/database.php');

		$select = $bdd->prepare("SELECT * FROM ecu WHERE codeECU=? AND libelleECU=? AND codeUE=? ");
		$select->execute(array($newCodeECU, $newLibECU, $newCodeUE));
		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée. Cette codification d'ECU existe déjà !";
		}
		else {
			$update = $bdd->prepare("UPDATE ecu SET codeECU=?, libelleECU=?, codeUE=? WHERE codeECU='$codeECU' ");
			$update->execute(array($newCodeECU, $newLibECU, $newCodeUE));

			print "L'ECU a été modifié avec succès";
		}	
	}

	public function delete() {

		$codeECU = $this->codeECU;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ecu WHERE codeECU='$codeECU' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cet ECU n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM ecu WHERE codeECU='$codeECU' ");

			print "L'ECU a été supprimé avec succès";
		}
	}

}