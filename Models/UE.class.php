<?php
	if(!isset($_SESSION))
		session_start();
class UE {
	
	private $idUE; // l'id de l'UE
	private $codeUE; // le code de l'UE
	private $libUE; // libellé de l'UE
	private $coefUE; // coefficient de l'UE
	private $natureUE; //nature de l'UE

	//clé etrangere
	private $codeTypeUE; // le code du type de l'UE
	private $semestre;

	function __construct($idUE,$codeUE,$libUE,$coefUE,$codeTypeUE, $semestre, $natureUE) {

		$this->idUE = $idUE;
		$this->codeUE = $codeUE;
		$this->libUE = $libUE;
		$this->coefUE = $coefUE;
		$this->codeTypeUE = $codeTypeUE;
		$this->semestre = $semestre;
		$this->natureUE = $natureUE;

	}

	public function getIdUE(){
		return $this->idUE;
	}
	public function setIdUE($newIdUE){
			if(!empty($newIdUE))
				$this->idUE = $newIdUE;
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

	public function getCodeTypeUE(){
		return $this->codeTypeUE;
	}
	   
	public function getSemestre(){
		return $this->semestre;
   	}
   	public function setSemestre($newSemestre){
		if(!empty($newSemestre))
			 $this->semestre = $newSemestre;
   	}
   	public function getNatureUE(){
		return $this->natureUE;
	}
	public function setNatureUE($newNatureUE){
			if(!empty($newNatureUE))
				$this->natureUE = $newNatureUE;
	}

	public static function create($idUE, $codeUE, $libUE, $coefUE, $codeTypeUE, $semestre, $natureUE) {
		
		include('../Database/database.php');

		$codeUE = strtoupper($codeUE);
			
		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$request3 = $bdd->query("SELECT * FROM ue WHERE idUE LIKE '$encours%' AND codeUE='$codeUE'");
	
		if(!empty($request3) && $request3->rowCount() == 0) {
			
			$insertion = $bdd->prepare('INSERT INTO ue(idUE,codeUE, libelleUE, coef, codeTypeUE, semestre, natureUE) VALUES(?, ?, ?, ?, ?, ?, ?)');
			$insertion->execute(array($idUE, $codeUE, $libUE, $coefUE, $codeTypeUE, $semestre, $natureUE));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/ue.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Ajout d'UE $idUE $codeUE $libUE $coefUE $codeTypeUE $semestre natureUE par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';
			
		}else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : cette UE existe déjà !'; 
		}
	}

	public static function read($idUE) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue WHERE idUE='$idUE' ");
		$aUE = $select->fetchAll();
		if(!empty($aUE)) {
			$ue = new UE($aUE[0][0], $aUE[0][1], $aUE[0][2], $aUE[0][3], $aUE[0][4], $aUE[0][5], $aUE[0][6]);
			return $ue;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Lecture échouée : Cette UE n'existe pas !"; 
			return false;
		}
			
	}

	public static function findUEId($codeUE) {
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();
		if($encours) {
			$annee = $encours->getIdAnnee();
		}
		
		$select = $bdd->query("SELECT * FROM ue WHERE idUE LIKE '$annee%' AND codeUE='$codeUE' ");
		$aUE = $select->fetchAll();
		if(!empty($aUE)) {
			$ue = new UE($aUE[0][0], $aUE[0][1],$aUE[0][2], $aUE[0][3], $aUE[0][4], $aUE[0][5], $aUE[0][6]);
			return $ue;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cette ue n\'existe pas !';
			return false;
		}
	}

	public static function findCodeueUE($codeUE, $annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue WHERE codeUE='$codeUE' AND idUE LIKE '$annee%' ");
		$aUE = $select->fetchAll();
		if(!empty($aUE)) {
			$ue = new UE($aUE[0][0], $aUE[0][1], $aUE[0][2], $aUE[0][3], $aUE[0][4], $aUE[0][5], $aUE[0][6]);
			return $ue;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Lecture échouée : Cette UE n'existe pas !"; 
			return false;
		}
			
	}

	public static function getAllUE($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue, classe_ue WHERE ue.idUE=classe_ue.idUE AND ue.idUE LIKE '$annee%' ORDER BY ue.semestre ASC ");
		$allUE = $select->fetchAll();
		return $allUE;
	}

	public static function getAllUE2($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue WHERE idUE LIKE '$annee%' ");
		$allUE = $select->fetchAll();
		return $allUE;
	}

	public static function getClasseAllUE($idClasse) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue, classe_ue WHERE ue.idUE=classe_ue.idUE AND classe_ue.idClasse LIKE '%$idClasse%' ORDER BY ue.semestre ASC ");
		$allUE = $select->fetchAll();
		return $allUE;
	}

	public static function getUE_SemestreNature($semestre, $nature) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue WHERE semestre='$semestre' AND natureUE='$nature' ");

		$allSemNatUE = $select->fetchAll();

		return $allSemNatUE;
	}

	public static function getNbECU_SemestreNature($semestre, $nature) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue, ecu WHERE ue.idUE=ecu.idUE AND semestre='$semestre' AND natureUE='$nature' ");

		return $select->rowCount();
	}

	public function update($newCodeUE, $newLibUE, $newCoefUE, $newCodeTypeUE, $newSemestre, $newNatureUE) {
		 
		$idUE = $this->idUE;
		$codeUE = $this->codeUE;
		$libUE = $this->libUE;
		$coefUE = $this->coefUE;
		$codeTypeUE = $this->codeTypeUE;
		$semestre = $this->semestre;
		$natureUE = $this->natureUE;
		include('../Database/database.php');

		$newCodeUE = strtoupper($newCodeUE);

		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$select = $bdd->query("SELECT * FROM ue WHERE idUE LIKE '$encours%' AND codeUE='$newCodeUE'");

		if($codeUE != $newCodeUE && !empty($select) && $select->rowCount() > 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : Cette UE existe déjà !';
		}
		else {
			$update = $bdd->prepare("UPDATE ue SET codeUE=?, libelleUE=?, coef=?, codeTypeUE=?, semestre=?, natureUE=? WHERE idUE='$idUE' ");
			$update->execute(array($newCodeUE, $newLibUE, $newCoefUE, $newCodeTypeUE, $newSemestre, $newNatureUE));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/ue.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification d'UE ''$idUE $codeUE $libUE $coefUE $codeTypeUE $semestre $natureUE'' en ''$newCodeUE $newLibUE $newCoefUE $newCodeTypeUE $newSemestre $newNatureUE'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !'; 
		}
	}

	public function delete() {

		$idUE = $this->idUE;
		$codeUE = $this->codeUE;
		$libUE = $this->libUE;
		$coefUE = $this->coefUE;
		$codeTypeUE = $this->codeTypeUE;
		$semestre = $this->semestre;
		$natureUE = $this->natureUE;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM ue WHERE idUE='$idUE' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : Cette UE n\'existe pas !'; 
		}
		else {	
			$delete = $bdd->exec("DELETE FROM ue WHERE idUE='$idUE' ");

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/ue.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Suppression d'UE ''$idUE $codeUE $libUE $coefUE $codeTypeUE $semestre $natureUE'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppression effectuée avec succès !'; 
		}
	}

	public function getMoyUE($idEtudiant) {
		
		include('../Database/database.php');
		include_once '../Models/Evaluation.class.php';
		include_once '../Models/ClasseUE.class.php';
		include_once '../Models/TypeEval.class.php';
		include_once '../Models/UE.class.php';
		include_once '../Models/ECU.class.php';
		include_once '../Models/Etudiant.class.php';
		include_once '../Models/Classe.class.php';
		include_once '../Models/Etudier.class.php';
		include_once '../Models/Obtenir.class.php';
		include_once '../Models/Filiere.class.php';
		include_once '../Models/Niveau.class.php';
		include_once '../Models/Statut.class.php';
		
		$idUE = $this->idUE;
		$moy = 0.0;
		$smecu = 0;
		$secu = 0;

		$nbECU = ECU::getUEECUNumber($idUE);
		$ecus = ECU::getUEECU($idUE);

		foreach($ecus as $ecu) {

			//Ici il faut vérifier si l'étudiant à une reprise
			$rp = Evaluation::getEvalNote("RP", $ecu['idECU'], $idEtudiant);
			if(isset($rp) && !empty($rp)) {
				$cc = $rp;
				$ef = $rp;
			}
			else {
				$cc = Evaluation::getEvalNote("CC", $ecu['idECU'], $idEtudiant);
				$ef = Evaluation::getEvalNote("EF", $ecu['idECU'], $idEtudiant);
			}

			if($cc == "DEF" || $ef == "DEF") {//S'il y a un seul défaillant
				return -1;
			}

			if(empty($cc) && !empty($ef)) {
				$cc = $ef;
			}

			$mecu = $cc*0.4+$ef*0.6;
			$smecu = $smecu + $mecu;
		}

		$moy = 0;
		if($nbECU > 0) {
			$moy = $smecu/$nbECU;
		}

		return $moy;
	}

	public function getECU() {
		include('../Database/database.php');
		$idUE = $this->idUE;
		$select = $bdd->query("SELECT * FROM ecu WHERE idUE='$idUE' ");
		$allECU = $select->fetchAll();
		return $allECU;
	}

	public function getNbrECU() {
		include('../Database/database.php');
		$idUE = $this->idUE;
		$select = $bdd->query("SELECT * FROM ecu WHERE idUE='$idUE'");
		return $select->rowCount();
	}

	public function ajusterUE($idClasse, $idEtudiant) {

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		include_once '../Models/UE.class.php';
		include_once '../Models/ECU.class.php';
		include_once '../Models/Classe.class.php';

		// $idUE = $this->getIdUE();
		// $typeUE = $this->getCodeTypeUE();
		$moyenne = $this->getMoyUE($idEtudiant);
		// $encours = AnneeAcademique::encours();
		$ecus = $this->getECU();
		$nbrECU = $this->getNbrECU();

		// if($typeUE == "TC") {
		// 	$validation = (Classe::read($idClasse))->getValidationTC();
		// }
		// else {
		// 	$validation = (Classe::read($idClasse))->getValidationSP();
		// }

		if($nbrECU == 1) {
			$ecu = $ecus[0];

			$cc = Evaluation::getEvalNote("CC", $ecu['idECU'], $idEtudiant);
			$ef = Evaluation::getEvalNote("EF", $ecu['idECU'], $idEtudiant);

			if($cc == "DEF" || $ef == "DEF") {//S'il y a un seul défaillant
				return -1;
			}
			else if(empty($cc) && !empty($ef)) {
				$efa[] = 12;
				// $cc = $efa;
			}
			else {
				$note = (12 - 0.4*$cc)/0.6;
				// $arrondi = round($note, 0.5, PHP_ROUND_HALF_UP);
				// $efa[] = $arrondi >= $note ? $arrondi : $arrondi+0.5 ;
				$efa[] = $note;
			}

		}
		else {

			$somEFA = 0;
			$somEF = 0;
			foreach($ecus as $ecu) {

				$ef = Evaluation::getEvalNote("EF", $ecu['idECU'], $idEtudiant);
				if($ef == "DEF") {
					return -1;
				}

				$somEF += $ef;
			}

			$somEFA = $somEF + (((12 - $moyenne)*$nbrECU)/0.6);

			$diff = ($somEFA - $somEF) / $nbrECU;
			// $arrondi = round($diff, 0.5, PHP_ROUND_HALF_UP);
			// $part = $arrondi >= $diff ? $arrondi : $arrondi+0.5 ;
			foreach($ecus as $ecu) {

				$ef = Evaluation::getEvalNote("EF", $ecu['idECU'], $idEtudiant);
				if($ef == "DEF") {
					return -1;
				}

				$efa[] = $ef + $diff;
			}
		}
		
		return $efa;

	}

	public static function genererIdUE() {

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();

		$select = $bdd->query("SELECT * FROM ue");

		if(!empty($select) && $select->rowCount() == 0){
			$idUE = ($encours)->getIdAnnee() .'-1';
		}
		else {

			$ues = UE::getAllUE2($encours->getIdAnnee());

			foreach($ues as $ue) {
				$ueId[] =  (explode("-", $ue['idUE']))[1] ;
			}
			
			$max = $ueId[0];
			
			for($i = 1; $i < count($ueId); $i++) {
				if($ueId[$i] > $max) {
					$max = $ueId[$i];
				}
			}
			$a = $max+1;
			$idUE = $encours->getIdAnnee() .'-'.$a;
		}
		
		return $idUE;
	}

}