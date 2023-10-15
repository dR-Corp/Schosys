<?php
	if(!isset($_SESSION))
		session_start();
class Niveau {

	private $idNiveau;
	private $codeNiveau;
	private $libNiveau;
	private $duree;

	function __construct($idNiveau,$codeNiveau,$libNiveau,$duree) {
			
		$this->idNiveau=$idNiveau;
		$this->codeNiveau=$codeNiveau;
		$this->libNiveau=$libNiveau;
		$this->duree=$duree;

	}

	public function getIdNiveau() {
		return $this->idNiveau;
	}
	public function setIdNiveau($newIdNiveau) {
		if(!empty($newIdNiveau))
			$this->idNiveau = $newIdNiveau;
	}

	public function getDuree() {
		return $this->duree;
	}
	public function setDuree($newDuree) {
		if(!empty($newDuree))
			$this->duree = $newDuree;
	}

	public function getCodeNiveau() {
		return $this->codeNiveau;
	}
	public function setCodeNiveau($newCodeNiveau) {
		if(!empty($newCodeNiveau))
			$this->codeNiveau = $newCodeNiveau;
	}

	public function getLibNiveau() {
		return $this->libNiveau;
	}
	public function setLibNiveau($newLibNiveau) {
		if(!empty($newLibNiveau))
			$this->libNiveau = $newLibNiveau;
	}

	public static function create($idNiveau, $codeNiveau, $libNiveau, $duree) {
		
		include("../Database/database.php");

		$codeNiveau = strtoupper($codeNiveau);

		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$select = $bdd->query("SELECT * FROM niveau WHERE idNiveau LIKE '$encours%' AND codeNiveau='$codeNiveau'");
	
		if(!empty($select) && $select->rowCount() == 0){

			$insert=$bdd->prepare("INSERT INTO niveau(idNiveau,codeNiveau,libelleNiveau,duree) VALUES(?,?,?,?)");
			$insert->execute(array($idNiveau,$codeNiveau,$libNiveau,$duree));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/niveau.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Ajout de niveau $idNiveau $codeNiveau $libNiveau $duree par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : ce code de niveau existe deja !';
		}
		
	}

	public static function read($idNiveau) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM niveau WHERE idNiveau='$idNiveau' ");
		$aNiveau = $select->fetchAll();
		if(!empty($aNiveau)) {
			$niveau = new Niveau($aNiveau[0][0], $aNiveau[0][1], $aNiveau[0][2], $aNiveau[0][3]);
			return $niveau;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Niveau introuvable !';
			return false;
		}
	}

	public static function findNiveauId($codeNiveau) {
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();
		if($encours) {
			$annee = $encours->getIdAnnee();
		}
		
		$select = $bdd->query("SELECT * FROM niveau WHERE idNiveau LIKE '$annee%' AND codeNiveau='$codeNiveau' ");
		$aNiveau = $select->fetchAll();
		if(!empty($aNiveau)) {
			$niveau = new Niveau($aNiveau[0][0], $aNiveau[0][1], $aNiveau[0][2], $aNiveau[0][3]);
			return $niveau;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : ce niveau n\'existe pas !';
			return false;
		}
	}

	public static function getAllNiveau($annee) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM niveau WHERE idNiveau LIKE '$annee%' ");
		$allNiveau = $select->fetchAll();
		return $allNiveau;
	}

	public function update($newCodeNiveau, $newLibNiveau, $duree) {

		$newCodeNiveau = strtoupper($newCodeNiveau);

		$idNiveau = $this->idNiveau;
		$codeNiveau = $this->codeNiveau;
		$libNiveau = $this->libNiveau;
		$duree = $this->duree;
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$select = $bdd->query("SELECT * FROM niveau WHERE idNiveau LIKE '$encours%' AND codeNiveau='$newCodeNiveau'");
	
		if($codeNiveau != $newCodeNiveau && !empty($select) && $select->rowCount() > 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : ce code de niveau est déjà utilisé !';
		}
		else {	
			$update = $bdd->prepare("UPDATE niveau SET codeNiveau=?, libelleNiveau=?, duree=? WHERE idNiveau='$idNiveau' ");
			$update->execute(array($newCodeNiveau, $newLibNiveau, $duree));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/niveau.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification de niveau ''$idNiveau $codeNiveau $libNiveau $duree'' en ''$newCodeNiveau $newLibNiveau $duree)'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}	
	}

	public function delete() {

		$idNiveau = $this->idNiveau;
		$codeNiveau = $this->codeNiveau;
		$libNiveau = $this->libNiveau;
		$duree = $this->duree;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM niveau WHERE idNiveau='$idNiveau' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "";
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : ce niveau n\'existe pas !';
		}
		else {	
			$delete = $bdd->exec("DELETE FROM niveau WHERE idNiveau='$idNiveau' ");

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/niveau.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Suppression de niveau ''$idNiveau $codeNiveau $libNiveau $duree'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppresssion effectuée avec succès !';
		}
	}

	public static function getNbNiveau($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM niveau WHERE idNiveau LIKE '$annee%'");

		return $select->rowCount();
	}

	public static function genererIdNiveau() {

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();

		$select = $bdd->query("SELECT * FROM niveau");

		if(!empty($select) && $select->rowCount() == 0){
			$idNiveau = ($encours)->getIdAnnee() .'-1';
		}
		else {

			$niveaux = Niveau::getAllNiveau($encours->getIdAnnee());

			foreach($niveaux as $niveau) {
				$niveauId[] =  (explode("-", $niveau['idNiveau']))[1] ;
			}
			$max = $niveauId[0];
			
			for($i = 1; $i < count($niveauId); $i++) {
				if($niveauId[$i] > $max) {
					$max = $niveauId[$i];
				}
			}
			$a = $max+1;
			$idNiveau = (AnneeAcademique::encours())->getIdAnnee() .'-'.$a;
		}
		
		return $idNiveau;
	}

}