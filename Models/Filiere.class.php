<?php
if(!isset($_SESSION))
		session_start();

class Filiere {

	private $idFiliere;
	private $codeFiliere;
	private $libFiliere;

	function __construct($idFiliere,$codeFiliere,$libFiliere) {
			
		$this->idFiliere=$idFiliere;
		$this->codeFiliere=$codeFiliere;
		$this->libFiliere=$libFiliere;

	}

	public function getIdFiliere() {
		return $this->idFiliere;
	}
	public function setIdFiliere($newIdFiliere) {
		if(!empty($newIdFiliere))
			$this->idFiliere = $newIdFiliere;
	}

	public function getCodeFiliere() {
		return $this->codeFiliere;
	}
	public function setCodeFiliere($newCodeFiliere) {
		if(!empty($newCodeFiliere))
			$this->codeFiliere = $newCodeFiliere;
	}

	public function getLibFiliere() {
		return $this->libFiliere;
	}
	public function setLibFiliere($newLibFiliere) {
		if(!empty($newLibFiliere))
			$this->libFiliere = $newLibFiliere;
	}

	public static function create($idFiliere,$codeFiliere, $libFiliere) {

		$codeFiliere = strtoupper($codeFiliere);
		
		include("../Database/database.php");
		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$select = $bdd->query("SELECT * FROM filiere WHERE idFiliere LIKE '$encours%' AND codeFiliere='$codeFiliere'");

		if(!empty($select) && $select->rowCount()==0){

			$insert=$bdd->prepare("INSERT INTO filiere(idFiliere,codeFiliere,libelleFiliere) VALUES(?,?,?)");
			$insert->execute(array($idFiliere,$codeFiliere,$libFiliere));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/filiere.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Ajout de filiere $idFiliere $codeFiliere $libFiliere par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

		}else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : cette filière existe déjà !';
		}
		
	}

	public static function read($idFiliere) {

		include('../Database/database.php');
		
		$select = $bdd->query("SELECT * FROM filiere WHERE idFiliere='$idFiliere' ");
		$aFiliere = $select->fetchAll();
		if(!empty($aFiliere)) {
			$filiere = new Filiere($aFiliere[0][0], $aFiliere[0][1], $aFiliere[0][2]);
			return $filiere; 
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Lecture échouée : cette filière n'existe pas !";
		}

	}

	public static function findFiliereId($codeFiliere) {
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();
		if($encours) {
			$annee = $encours->getIdAnnee();
		}
		
		$select = $bdd->query("SELECT * FROM filiere WHERE idFiliere LIKE '$annee%' AND codeFiliere='$codeFiliere' ");
		$aFiliere = $select->fetchAll();
		if(!empty($aFiliere)) {
			$filiere = new Filiere($aFiliere[0][0], $aFiliere[0][1],$aFiliere[0][2]);
			return $filiere;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cette filière n\'existe pas !';
			return false;
		}
	}

	public static function getAllFiliere($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM filiere WHERE idFiliere LIKE '$annee%'");
		$allFiliere = $select->fetchAll();
		return $allFiliere;
	}

	public static function getAllFiliereNiveau($annee, $idNiveau) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM filiere, classe, niveau WHERE classe.idFiliere=filiere.idFiliere AND classe.idNiveau=niveau.idNiveau AND filiere.idFiliere LIKE '$annee%' AND niveau.idNiveau='$idNiveau' GROUP BY filiere.idFiliere");
		$allFiliere = $select->fetchAll();
		return $allFiliere;
	}

	public function update($newCodeFiliere, $newLibFiliere) {

		$idFiliere = $this->idFiliere;
		$codeFiliere = $this->codeFiliere;
		$libFiliere = $this->libFiliere;

		$newCodeFiliere = strtoupper($newCodeFiliere);

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';

		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$select = $bdd->query("SELECT * FROM filiere WHERE idFiliere LIKE '$encours%' AND codeFiliere='$newCodeFiliere'");		
		if( $codeFiliere != $newCodeFiliere && !empty($select) && $select->rowCount() >=1) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : ce code filière existe déjà !';
		}
		else {
			$update = $bdd->prepare("UPDATE filiere SET codeFiliere=?, libelleFiliere=? WHERE idFiliere='$idFiliere' ");
			$update->execute(array($newCodeFiliere, $newLibFiliere));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/filiere.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification de filiere ''$idFiliere $codeFiliere $libFiliere'' en ''$newCodeFiliere $newLibFiliere'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}
	}

	public function delete() {

		$idFiliere = $this->idFiliere;
		$codeFiliere = $this->codeFiliere;
		$libFiliere = $this->libFiliere;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM filiere WHERE idFiliere='$idFiliere' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Suppression échouée : cette filière n'existe pas !";
		}else {	
			$delete = $bdd->exec("DELETE FROM filiere WHERE idFiliere='$idFiliere' ");

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/filiere.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Suppression de filiere ''$idFiliere $codeFiliere $libFiliere'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
		}

	}

	public static function getNbFiliere($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM filiere WHERE idFiliere LIKE '$annee%'");

		return $select->rowCount();
	}

	public static function genererIdFiliere() {

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();

		$select = $bdd->query("SELECT * FROM filiere");

		if(!empty($select) && $select->rowCount() == 0){
			$idFiliere = ($encours)->getIdAnnee() .'-1';
		}
		else {

			$filieres = Filiere::getAllFiliere($encours->getIdAnnee());

			foreach($filieres as $filiere) {
				$filId[] =  (explode("-", $filiere['idFiliere']))[1] ;
			}
			$max = $filId[0];
			
			for($i = 1; $i < count($filId); $i++) {
				if($filId[$i] > $max) {
					$max = $filId[$i];
				}
			}
			$a = $max+1;
			$idFiliere = $encours->getIdAnnee() .'-'.$a;
		}
		
		return $idFiliere;
	}

}