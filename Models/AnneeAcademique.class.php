<?php
	if(!isset($_SESSION))
		session_start();

class AnneeAcademique {

	private $idAnnee;
	private $annee;
	private $encours;

	function __construct($idAnnee,$annee) {
		$this->idAnnee=$idAnnee;
		$this->annee=$annee;
	}

	public function getIdAnnee() {
		return $this->idAnnee;
	}
	public function setIdAnnee($newIdAnnee) {
		if(!empty($newIdAnnee))
			$this->idAnnee = $newIdAnnee;
	}

	public function getAnnee() {
		return $this->annee;
	}
	public function setAnnee($newAnnee) {
		if(!empty($newAnnee))
			$this->annee = $newAnnee;
	}

	public static function create($idAnnee, $annee) {
		
		include_once("../Database/database.php");

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee'");

		if(!empty($select) && $select->rowCount()==0){

			$insert=$bdd->prepare("INSERT INTO anneeacad(idAnnee,annee) VALUES(?,?)");
			$insert->execute(array($idAnnee,$annee));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/annees.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Création d'année académique $annee par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

			$annee = AnneeAcademique::read($idAnnee);
			if ($annee) {
				$annee->start();
				$_SESSION['start'] = true;
				
				//Après la création d'une nouvelle année académique celle ci commence
				//On donc bascule directement vers elle.
				$_SESSION['anneeAcad'] = $idAnnee;
				print "<script> location.replace('dashboard.php?anneeAcad=".$idAnnee."'); </script>";
			}
			
		}
		else{

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : cette année academique existe déjà !';
		}
		
	}

	public static function read($idAnnee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee' ");
		$aAnneeAcad = $select->fetchAll();
		if(!empty($aAnneeAcad)) {
			$annee = new AnneeAcademique($aAnneeAcad[0][0], $aAnneeAcad[0][1], $aAnneeAcad[0][2]);
			return $annee;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échoué : cette année academique n\'existe pas !';
			return false;
		}
	}

	public static function getAllAnneeAcademique() {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM anneeacad ");
		$allAnneeAcad = $select->fetchAll();
		return $allAnneeAcad;
	}

	public function update($newIdAnnee, $newAnnee) {

		$idAnnee = $this->idAnnee;
		$annee = $this->annee;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$newIdAnnee' ");
		if(!empty($select) && $select->rowCount() >=1) {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : cette année académique existe déjà !';
		}
		else {
			$update = $bdd->prepare("UPDATE anneeacad SET idAnnee=?, annee=? WHERE idAnnee='$idAnnee' ");
			$update->execute(array($newIdAnnee, $newAnnee));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/annees.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification d'année académique ''$annee'' en ''$newAnnee'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès';
		}	
	}

	public function delete() {
		$idAnnee = $this->idAnnee;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppresssion échoué :  cette année académique n\'existe pas !';
		}
		else {
			$delete = $bdd->exec("DELETE FROM anneeacad WHERE idAnnee='$idAnnee' ");

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
		}
	}

	public static function encours() {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM anneeacad WHERE encours=1");
		if(!empty($select) && $select->rowCount() > 0) {

			$aAnneeAcad = $select->fetchAll();
			$annee = new AnneeAcademique($aAnneeAcad[0][0], $aAnneeAcad[0][1]);
			return $annee;
		}
		else {
			return false;
		}

	}

	public static function en_cours() {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM anneeacad WHERE encours=1");
		if(!empty($select) && $select->rowCount() > 0) {
			return true;
		}
		else {
			return false;
		}

	}

	public function start() {

		$idAnnee = $this->idAnnee;
		include('../Database/database.php');
		
		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$an = $select->fetchAll();
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Echec : cette année académique n\'existe pas !';
		}
		else {

			if(self::encours()) {

				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Une année académique est déjà en cours : imposssible d\'en commencer une autre !';
			}
			else {
				$update = $bdd->exec("UPDATE anneeacad SET encours=1 WHERE idAnnee='$idAnnee' ");

				include_once '../Models/ProfilUser.class.php';
				$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
				$eventsFile = fopen("../Uploads/annees.txt", "a+");
				fputs($eventsFile, date('d/m/Y H:i:s')." L'année académique ''$annee'' a commmencé : par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
				fclose($eventsFile);

				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = 'L\'année académique '.$this->annee.' a commencé !';
			}

		}

	}

	public function end() {

		$idAnnee = $this->idAnnee;
		include('../Database/database.php');
		
		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idAnnee' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Echec : cette année académique n\'existe pas !';
		}
		else {

			if(!self::encours()) {
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Echec : cette année academique n\'est pas en cours : impossible de la terminer !';
			}
			else {
				$update = $bdd->exec("UPDATE anneeacad SET encours=0 WHERE idAnnee='$idAnnee' ");

				include_once '../Models/ProfilUser.class.php';
				$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
				$eventsFile = fopen("../Uploads/annees.txt", "a+");
				fputs($eventsFile, date('d/m/Y H:i:s')." L'année académique ''$annee'' est terminée : par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
				fclose($eventsFile);

				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = 'L\'année académique '.$an[0][1].' est terminée !';
			}

		}

	}

	public static function anneePassee() {

		$idEncours = (AnneeAcademique::encours())->getIdAnnee();
		$p1 = $idEncours[0]."".$idEncours[1]."".$idEncours[2]."".$idEncours[3];
		$p2 = $idEncours[4]."".$idEncours[5]."".$idEncours[6]."".$idEncours[7];
		$idPassee = ($p1-1)."".($p2-1);

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idPassee' ");
		$aAnneeAcad = $select->fetchAll();
		if(!empty($aAnneeAcad && $select->rowCount() > 0)) {
			$annee = new AnneeAcademique($aAnneeAcad[0][0], $aAnneeAcad[0][1], $aAnneeAcad[0][2]);
			return $annee;
		}
		else {
			return false;
		}

	}

	public static function anneePrecedente($annee) {

		$idPrecedent = $annee;
		$idPrecedent[3] = $annee[3]-1;
		$idPrecedent[7] = $annee[7]-1;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM anneeacad WHERE idAnnee='$idPassee' ");
		$aAnneeAcad = $select->fetchAll();
		if(!empty($aAnneeAcad)) {
			$annee = new AnneeAcademique($aAnneeAcad[0][0], $aAnneeAcad[0][1], $aAnneeAcad[0][2]);
			return $annee;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échoué : cette année academique n\'existe pas !';
			return false;
		}

	}

}