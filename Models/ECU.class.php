<?php
if(!isset($_SESSION))
	session_start();
class ECU {

	private $idECU; // id de l'ECU
	private $codeECU; // code de l'ECU
	private $libECU; // libellé de l'ECU

	// clé etrangere
	private $idUE; // code de l'UE auquel appartient l'ECU

	function __construct($idECU,$codeECU,$libECU,$idUE){

		$this->idECU=$idECU;
		$this->codeECU=$codeECU;
		$this->libECU=$libECU;
		$this->idUE=$idUE;

	}

	public function getIdECU(){
		return $this->idECU;
	}
	public function setIdECU($newIdECU){
		if(!empty($newIdECU))
			$this->idECU = $newIdECU;
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
	public function getIdUE(){
		return $this->idUE;
	}

	public static function create($idECU, $codeECU, $libECU, $idUE) {

		$codeECU = strtoupper($codeECU);
		
		include('../Database/database.php');
		$request1 = $bdd->query("SELECT * FROM ecu WHERE codeECU='$codeECU'");

		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$request1 = $bdd->query("SELECT * FROM ecu WHERE idECU LIKE '$encours%' AND codeECU='$codeECU'");
	
		if(!empty($request1) && $request1->rowCount() == 0) {

			$insert =$bdd->prepare("INSERT INTO ecu(idECu,codeEcu,libelleEcu,idUE) VALUES(?,?,?,?)");
			$insert->execute(array($idECU,$codeECU,$libECU,$idUE));

			include_once '../Models/ProfilUser.class.php';
			include_once '../Models/UE.class.php';
			include_once '../Models/ECU.class.php';
			include_once '../Models/TypeEval.class.php';
			include_once '../Models/Evaluation.class.php';
			$ue = (UE::read($idUE))->getCodeUE();
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/ecu.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Ajout d'ECU $idECU $codeECU $libECU ($ue) par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			//***************************** */ Try to create ECU evals after ECU creation

			$encours = (AnneeAcademique::encours())->getIdAnnee();
			$evaluations = TypeEval::getAllTypeEval();

			if(ECU::read($idECU)) {
				foreach($evaluations as $evaluation) {

					$codeTypeEval = $evaluation['codeTypeEval'];

					$codeEvaluation = $codeTypeEval.'-'.(ECU::read($idECU))->getCodeECU();

					//Gestion de l'apostrophe pour le cas où de libelle de l'ECU commence par une voyelle
					$libECU = (ECU::read($idECU))->getLibECU();
					$libType = (TypeEval::read($codeTypeEval))->getLibTypeEval();
					$l = $libECU;
					if($l[0] == "A" || $l[0] == "E" || $l[0] == "I" || $l[0] == "O" || $l[0] == "U" || $l[0] == "Y") {
						$libelleEvaluation = $libType." d'".$libECU;
					}
					else {
						$libelleEvaluation = $libType." de ".$libECU;
					}

					if (isset($codeEvaluation) && !empty($codeEvaluation) && isset($libelleEvaluation) && !empty($libelleEvaluation) && isset($codeTypeEval) && !empty($codeTypeEval) && isset($idECU) && !empty($idECU)) {
						
						$idEvaluation = Evaluation::genererIdEvaluation();
						Evaluation::create($idEvaluation, $codeEvaluation, $libelleEvaluation, $codeTypeEval, $idECU);
						
					}
					
				}
			}

			//***************************** */

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

		}else{ 
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Ajout échoué : cet ECU existe déjà !";
		}
	}

	public static function read($idECU) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu WHERE idECU='$idECU' ");
		$aECU = $select->fetchAll();

		if (!empty($aECU)) {
			$ecu = new ECU($aECU[0][0], $aECU[0][1], $aECU[0][2], $aECU[0][3]);
			return $ecu;
		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Lecture échouée : cet ECU n'existe pas !";
			return false;
		}
	}

	public static function getAllECU($annee) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu WHERE idECU LIKE '$annee%' ");
		$allECU = $select->fetchAll();
		return $allECU;
	}

	public static function findCodeecuECU($codeECU, $annee) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu WHERE codeECU='$codeECU' AND idECU LIKE '$annee%' ");
		$aECU = $select->fetchAll();

		if (!empty($aECU)) {
			$ecu = new ECU($aECU[0][0], $aECU[0][1], $aECU[0][2], $aECU[0][3]);
			return $ecu;
		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Lecture échouée : cet ECU n'existe pas !";
			return false;
		}
	}

	public static function getAllECUFiliere($annee, $idFiliere) {
		include('../Database/database.php');
		include_once 'Classe.class.php';
		$select = $bdd->query("SELECT * FROM ecu,ue,classe_ue WHERE idECU LIKE '$annee%' AND ecu.idUE=ue.idUE AND ue.idUE=classe_ue.idUE ORDER BY codeECU");
		$select2 = $bdd->query("SELECT * FROM classe,filiere WHERE classe.idFiliere=filiere.idFiliere AND filiere.idFiliere='$idFiliere' ");
		$allECU = $select->fetchAll();
		$allClasse = $select2->fetchAll();
		foreach($allECU as $aECU) {

			$ids = explode(",", $aECU['idClasse']);
			$ordre = 0;
			foreach($ids as $id) {
				if($ordre == 0) {
					foreach($allClasse as $aClasse) {
						if($id == $aClasse['idClasse']) {
							$result[] = $aECU;
						}
					}
				}
				else if(Classe::findClasseFIliere($ids[$ordre]) != Classe::findClasseFIliere($ids[$ordre-1])){
					foreach($allClasse as $aClasse) {
						if($id == $aClasse['idClasse']) {
							$result[] = $aECU;
						}
					}
				}

				$ordre++;
			}

		}
		return $result;
	}

	public static function getAllECUClasse($annee, $idClasse) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu,ue,classe_ue WHERE idECU LIKE '$annee%' AND ecu.idUE=ue.idUE AND ue.idUE=classe_ue.idUE");
		$allECU = $select->fetchAll();
		foreach($allECU as $aECU) {
			$ids = explode(",", $aECU['idClasse']);
			foreach($ids as $id) {
				if($id == $idClasse) {
					$result[] = $aECU;
				}
			}
		}
		if(!isset($result)){
			$result = array();
		}
		return $result;
	}

	public static function getAllECUClasseFiliere($annee, $idClasse, $idFiliere) {
		include('../Database/database.php');
		include_once 'Classe.class.php';
		$select = $bdd->query("SELECT * FROM ecu,ue,classe_ue WHERE idECU LIKE '$annee%' AND ecu.idUE=ue.idUE AND ue.idUE=classe_ue.idUE ORDER BY codeECU");
		$select2 = $bdd->query("SELECT * FROM classe,filiere WHERE classe.idFiliere=filiere.idFiliere AND filiere.idFiliere='$idFiliere' AND classe.idClasse='$idClasse' ");
		$allECU = $select->fetchAll();
		$aClasse = $select2->fetchAll();
		$have = false;
		foreach($allECU as $aECU) {

			$ids = explode(",", $aECU['idClasse']);
			$ordre = 0;
			foreach($ids as $id) {
				
					if($id == $aClasse[0]['idClasse']) {
						$result[] = $aECU;
						$have = true;
					}

				$ordre++;
			}

		}
		if(!$have) {
			$result = array();
		}
		return $result;
	}
	
	public static function getUEECU($idUE) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu WHERE idUE='$idUE'");
		$allUEECU = $select->fetchAll();
		return $allUEECU;
	}

	public static function getUEECUNumber($idUE) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM ecu WHERE idUE='$idUE'");
		return $select->rowCount();
	}

	public function update($newCodeECU, $newLibECU, $newIdUE) {

		$newCodeECU = strtoupper($newCodeECU);

		$idECU = $this->idECU;
		$codeECU = $this->codeECU;
		$idUE = $this->idUE;
		$libECU = $this->libECU;
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$select = $bdd->query("SELECT * FROM ecu WHERE idECU LIKE '$encours%' AND codeECU='$newCodeECU'");

		if($codeECU != $newCodeECU && !empty($select) && $select->rowCount() > 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : cet ECU existe déjà !';
		}
		else {
			$update = $bdd->prepare("UPDATE ecu SET codeECU=?, libelleECU=?, idUE=? WHERE idECU='$idECU' ");
			$update->execute(array($newCodeECU, $newLibECU, $newIdUE));

			include_once '../Models/ProfilUser.class.php';
			include_once '../Models/UE.class.php';
			$ue = (UE::read($idUE))->getCodeUE();
			$newue = (UE::read($newIdUE))->getCodeUE();
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/ecu.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification d'ECU ''$idECU $codeECU $libECU ($ue)'' en ''$newCodeECU $newLibECU $newue'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}	
	}

	public function delete() {

		$idECU = $this->idECU;
		$codeECU = $this->codeECU;
		$idUE = $this->idUE;
		$libECU = $this->libECU;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ecu WHERE idECU='$idECU' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Suppression échouée : cet ECU n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM ecu WHERE idECU='$idECU' ");

			include_once '../Models/ProfilUser.class.php';
			include_once '../Models/UE.class.php';
			$ue = (UE::read($idUE))->getCodeUE();
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/ecu.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Suppression d'ECU ''$idECU $codeECU $libECU ($ue)'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
		}
	}

	public static function genererIdECU() {

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();

		$select = $bdd->query("SELECT * FROM ecu");

		if(!empty($select) && $select->rowCount() == 0){
			$idECU = ($encours)->getIdAnnee() .'-1';
		}
		else {

			$ecus = ECU::getAllECU($encours->getIdAnnee());

			foreach($ecus as $ecu) {
				$ecuId[] =  (explode("-", $ecu['idECU']))[1];
			}
			$max = $ecuId[0];
			
			for($i = 1; $i < count($ecuId); $i++) {
				if($ecuId[$i] > $max) {
					$max = $ecuId[$i];
				}
			}
			$a = $max+1;
			$idECU = $encours->getIdAnnee() .'-'.$a;
		}
		
		return $idECU;
	}

	public function getMoyECU($idEtudiant, $idUE, $idClasse) {
		
		include_once '../Models/Evaluation.class.php';
		
		$idECU = $this->idECU;
		$moy = 0;

		//ajustement
		$laClasse = Classe::read($idClasse);
		$lUE = UE::read($idUE);
		$moyUE = $lUE->getMoyUE($idEtudiant);
		//unset($efa);

		if($lUE->getCodeTypeUE() == "TC") {
			$validation = $laClasse->getValidationTC();
		}
		else {
			$validation = $laClasse->getValidationSP();
		}

		if($validation != 12 && $moyUE < 12 && $moyUE >= $validation) {
			
			$efa = $lUE->ajusterUE($idClasse, $idEtudiant);
			
		}
		//fin ajustement

		$cc = Evaluation::getEvalNote("CC", $idECU, $idEtudiant);
		if(isset($efa)) {
			$ecuse = ECU::getUEECU($idUE);
			$i = 0;
			foreach($ecuse as $ecu) {
				if($ecu['idECU'] == $idECU) {
					$ef = number_format(($efa[$i]), 2);
				}
				$i++;
			}
		}
		else {
			$ef = Evaluation::getEvalNote("EF", $idECU, $idEtudiant);
		}

		if(empty($cc) && !empty($ef)) {
			$cc = $ef;
		}

		if($cc == "DEF" || $ef == "DEF") {//S'il y a un seul défaillant
			return -1;
		}

		$moy = $cc*0.4+$ef*0.6;

		return $moy;
	}

}