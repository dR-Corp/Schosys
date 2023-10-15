<?php
	if(!isset($_SESSION))
		session_start();

class Obtenir {

	private $note;
	private $idEtudiant;
	private $idEvaluation;

	function __construct($idEvaluation,$idEtudiant,$note) {
		
		$this->idEvaluation=$idEvaluation;
		$this->idEtudiant=$idEtudiant;
		$this->note=$note;

	}

	public function getNote() {
		return $this->note;
	}
	public function setNote($newNote) {
		if(!empty($newNote))
			$this->note = $newNote;
	}

	public static function create($idEvaluation, $idEtudiant, $note) {
		
		include("../Database/database.php");

		$select=$bdd->query("SELECT note FROM obtenir WHERE idEtudiant='$idEtudiant' AND idEvaluation='$idEvaluation'");

		if(!empty($select) && $select->rowCount()==0){

			$insert=$bdd->prepare("INSERT INTO obtenir(idEvaluation,idEtudiant,note) VALUES(?,?,?)");
			$insert->execute(array($idEvaluation,$idEtudiant,$note));

			include_once '../Models/ProfilUser.class.php';
			include_once '../Models/Evaluation.class.php';
			include_once '../Models/Etudiant.class.php';
			$etuObject = Etudiant::read($idEtudiant);
			$etu = $etuObject->getMatriculeEtu()." ".$etuObject->getNomEtu()." ".$etuObject->getPrenomEtu();
			$evalObject = Evaluation::read($idEvaluation);
			$eval = $evalObject->getLibEval();
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/notes.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Ajout d'une note $etu $eval par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : cet étudiant a déjà une note pour cet ECU !';
		}
		
	}

	public static function read($idEvaluation, $idEtudiant) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE idEvaluation='$idEvaluation' AND idEtudiant='$idEtudiant' ");
		$aObtenir = $select->fetchAll();
		if(!empty($aObtenir)) {
			$obtenir = new Obtenir($aObtenir[0][0], $aObtenir[0][1], $aObtenir[0][2]);
			return $obtenir;
		}
		else {
			return false;
		}
	}

	public static function getallobtenir($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE idEtudiant LIKE '$annee%' AND idEvaluation LIKE '$annee%' ");
		$allObtenir = $select->fetchAll();
		return $allObtenir;
	}

	public function update($note) {

		$idEvaluation = $this->idEvaluation;
		$idEtudiant = $this->idEtudiant;
		$aNote = $this->note;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE idEvaluation='$idEvaluation' AND idEtudiant='$idEtudiant' ");
		if(!empty($select) && $select->rowCount() == 0) {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : cet étudiant n\'a pas encore une note pour cette evaluation';

		}
		else {	
			$update = $bdd->prepare("UPDATE obtenir SET note=? WHERE idEvaluation='$idEvaluation' AND idEtudiant='$idEtudiant' ");
			$update->execute(array($note));

			include_once '../Models/ProfilUser.class.php';
			include_once '../Models/Evaluation.class.php';
			include_once '../Models/Etudiant.class.php';
			$etuObject = Etudiant::read($idEtudiant);
			$etu = $etuObject->getMatriculeEtu()." ".$etuObject->getNomEtu()." ".$etuObject->getPrenomEtu();
			$evalObject = Evaluation::read($idEvaluation);
			$eval = $evalObject->getLibEval();
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/notes.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification d'une note ''$etu $eval $aNote'' en ''$note'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}	
	}

	public function delete() {

		$idEvaluation = $this->idEvaluation;
		$idEtudiant = $this->idEtudiant;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE idEvaluation='$idEvaluation' AND idEtudiant='$idEtudiant' ");
		if(!empty($select) && $select->rowCount() == 0) {
		
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : cette note n\'existe pas';
		}
		else {	
			$delete = $bdd->exec("DELETE FROM obtenir WHERE idEvaluation='$idEvaluation' AND idEtudiant='$idEtudiant' ");

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
		}
	}

	public static function findEval($idEvaluation) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM obtenir WHERE idEvaluation='$idEvaluation'");

		if(!empty($select) && $select->rowCount() == 0) {
			return false;
		}
		else {
			return true;
		}

	}

}