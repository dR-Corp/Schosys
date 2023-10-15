<?php 
	if(!isset($_SESSION))
		session_start();
class Etudiant {

	private $idEtudiant;
	private $matriculeEtu;
	private $nomEtu;
	private $prenomEtu;
	private $sexeEtu;
	private $telephoneEtu;
	private $dateNaissanceEtu;
	private $lieuNaissanceEtu;
	private $nationaliteEtu;
	// clé etrangere
	private $codeStatut;

	function __construct($idEtudiant,$matriculeEtu,$nomEtu,$prenomEtu,$sexeEtu,$telephoneEtu,$dateNaissanceEtu,$lieuNaissanceEtu,$nationaliteEtu,$codeStatut) {

		$this->idEtudiant = $idEtudiant;
		$this->matriculeEtu = $matriculeEtu;
		$this->nomEtu = $nomEtu;
		$this->prenomEtu = $prenomEtu;
		$this->sexeEtu = $sexeEtu;
		$this->telephoneEtu = $telephoneEtu;
		$this->dateNaissanceEtu = $dateNaissanceEtu;
		$this->lieuNaissanceEtu = $lieuNaissanceEtu;
		$this->nationaliteEtu = $nationaliteEtu;
		$this->codeStatut = $codeStatut;

	}
	
	// getters et setters id
	public function getIdEtudiant(){
		return $this->idEtudiant;
	}
	public function setIdEtudiant($newIdEtudiant){
		if(!empty($newIdEtudiant))
			$this->idEtudiant = $newIdEtudiant;
	}

	// getters et setters Matricule
	public function getMatriculeEtu(){
		return $this->matriculeEtu;
	}
	public function setMatriculeEtu($newMatriculeEtu){
		if(!empty($newMatriculeEtu))
			$this->matriculeEtu = $newMatriculeEtu;
	}

	// getters et setters Nom
	public function getNomEtu(){
		return $this->nomEtu;
	}
	public function setNomEtu($newNomEtu){
		if(!empty($newNomEtu))
			$this->nomEtu = $newNomEtu;
	}

	// getters et setters Prenom
	public function getPrenomEtu(){
		return $this->prenomEtu;
	}
	public function setPrenomEtu($newPrenomEtu){
		if(!empty($newPrenomEtu))
			$this->prenomEtu = $newPrenomEtu;
	}

	// getters et setters Sexe
	public function getSexeEtu(){
		return $this->sexeEtu;
	}
	public function setSexeEtu($newSexeEtu){
		if(!empty($newSexeEtu))
			$this->sexeEtu = $newSexeEtu;
	}

	// getters et setters Telephone
	public function getTelephoneEtu(){
		return $this->telephoneEtu;
	}
	public function setTelephoneEtu($newTelephoneEtu){
		if(!empty($newTelephoneEtu))
			$this->telephoneEtu = $newTelephoneEtu;
	}

	// getters et setters Date de naissance
	public function getDateNaissanceEtu(){
		return $this->dateNaissanceEtu;
	}
	public function setDateNaissanceEtu($newDateNaissanceEtu){
		if(!empty($newDateNaissanceEtu))
			$this->dateNaissanceEtu = $newDateNaissanceEtu;
	}

	// getters et setters lieu de naissance
	public function getLieuNaissanceEtu(){
		return $this->lieuNaissanceEtu;
	}
	public function setLieuNaissanceEtu($newLieuNaissanceEtu){
		if(!empty($newLieuNaissanceEtu))
			$this->lieuNaissanceEtu = $newLieuNaissanceEtu;
	}

	// getters et setters Nationalite
	public function getNationaliteEtu(){
		return $this->nationaliteEtu;
	}
	public function setNationaliteEtu($newNationaliteEtu){
		if(!empty($newNationaliteEtu))
			$this->nationaliteEtu = $newNationaliteEtu;
	}

	public static function create($idEtudiant,$matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut) {
		
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$request3 = $bdd->query("SELECT * FROM etudiant WHERE idEtudiant LIKE '$encours%' AND matricule='$matriculeEtu'");
	
		if(!empty($request3) && $request3->rowCount() == 0){

			$insertion = $bdd->prepare('INSERT INTO etudiant(idEtudiant, matricule, nom, prenom, sexe, telephone, datenaissance, lieunaissance, nationalite, codeStatut) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
			$insertion->execute(array($idEtudiant, $matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut));
		
			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/etudiant.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Ajout d'étudiant $idEtudiant $matriculeEtu $nomEtu $prenomEtu $sexeEtu $telephoneEtu $dateNaissanceEtu $lieuNaissanceEtu $nationaliteEtu $codeStatut par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajout effectué avec succès !';
		
		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : cet etudiant existe deja !';
		}
		
	}

	public static function read($idEtudiant) {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudiant WHERE idEtudiant='$idEtudiant' ");
		$aEtudiant = $select->fetchAll();
		if(!empty($aEtudiant)) {
			$etudiant = new Etudiant($aEtudiant[0][0], $aEtudiant[0][1], $aEtudiant[0][2], $aEtudiant[0][3],$aEtudiant[0][4], $aEtudiant[0][5],$aEtudiant[0][6], $aEtudiant[0][7], $aEtudiant[0][8], $aEtudiant[0][9]);
			return $etudiant;
		}
		else {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cet etudiant n\'existe pas !';
			return false;
		}
	}

	public static function getAllEtudiant($annee) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudiant, etudier WHERE etudiant.idEtudiant=etudier.idEtudiant AND etudiant.idEtudiant LIKE '$annee%' ORDER BY nom, prenom ASC");
		$allEtudiant = $select->fetchAll();
		return $allEtudiant;
	}

	public static function findMatriculeEtudiant($matricule, $annee) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudiant WHERE matricule = '$matricule' AND idEtudiant LIKE '$annee%' ");
		$aEtudiant = $select->fetchAll();
		if(!empty($aEtudiant)) {
			$etudiant = new Etudiant($aEtudiant[0][0], $aEtudiant[0][1], $aEtudiant[0][2], $aEtudiant[0][3],$aEtudiant[0][4], $aEtudiant[0][5],$aEtudiant[0][6], $aEtudiant[0][7], $aEtudiant[0][8], $aEtudiant[0][9]);
			return $etudiant;
		}
		else {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cet etudiant n\'existe pas !';
			return false;
		}
	}

	public function update($matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut) {

		$idEtudiant = $this->idEtudiant;
		$matricule = $this->matriculeEtu;
		$nom = $this->nomEtu;
		$prenom = $this->prenomEtu;

		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();

		$select = $bdd->query("SELECT * FROM etudiant WHERE idEtudiant LIKE '$encours%' AND matricule='$matriculeEtu'");
	
		if($matriculeEtu!=$matricule && !empty($select) && $select->rowCount() >=1) {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : ce matricule d\'étudiant est déjà utilisé !';
			
		}
		else {
			$update = $bdd->prepare("UPDATE etudiant SET matricule=?, nom=?, prenom=?, sexe=?, telephone=?, dateNaissance=?, lieuNaissance=?, nationalite=?, codeStatut=? WHERE idEtudiant='$idEtudiant' ");
			$update->execute(array($matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/etudiant.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification d'étudiant '' $idEtudiant $matricule $nom $prenom $sexe $telephone $dateNaissanceEtu $lieuNaissance $nationalite $statut'' en ''$idEtudiant $matricule $nomEtu $prenomEtu $sexeEtu $telephoneEtu $dateNaissanceEtu $lieuNaissanceEtu $nationaliteEtu $codeStatut'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modification effectuée avec succès !';
		}
	}

	public function delete() {

		$idEtudiant = $this->idEtudiant;
		$matriculeEtu = $this->matriculeEtu;
		$nomEtu = $this->nomEtu;
		$prenomEtu = $this->prenomEtu;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudiant WHERE idEtudiant='$idEtudiant' ");
		if(!empty($select) && $select->rowCount() == 0) {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : ce matricule d\'étudiant est déjà utilisé !';
			
		}
		else {
			$delete = $bdd->exec("DELETE FROM etudiant WHERE idEtudiant='$idEtudiant' ");

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/etudiant.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Suppression d'étudiant ''$idEtudiant $matriculeEtu $nomEtu $prenomEtu'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
		}
	}

	public static function getNbEtudiant($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudiant WHERE idEtudiant LIKE '$annee%'");

		return $select->rowCount();
	}

	public static function getNbMasculin($idClasse) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudiant, etudier WHERE sexe='M' AND idClasse='$idClasse' AND etudiant.idEtudiant=etudier.idEtudiant ");

		return $select->rowCount();
	}

	public static function getNbFeminin($idClasse) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudiant, etudier WHERE sexe='F' AND idClasse='$idClasse' AND etudiant.idEtudiant=etudier.idEtudiant ");

		return $select->rowCount();
	}

	public static function getClasseAllEtu($idClasse) {
		include('../Database/database.php');

		//Une posssibilité pour la liaison avec l'année
		//include_once '../Models/AnneeAcademique.class.php';
		// $encours = AnneeAcademique::encours();
		// if($encours) {
		// 	$annee = $encours->getIdAnnee();
		// }
		$select = $bdd->query("SELECT * FROM etudiant, etudier WHERE etudiant.idEtudiant=etudier.idEtudiant AND idClasse='$idClasse' ORDER BY nom, prenom ASC");
		$allEtudiant = $select->fetchAll();
		return $allEtudiant;
	}

	public static function getClasseNbEtu($idClasse) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudiant, etudier WHERE etudiant.idEtudiant=etudier.idEtudiant AND idClasse='$idClasse' ");

		return $select->rowCount();
	}

	public static function getMoyAllEtudiant($idClasse) {

		include('../Database/database.php');
		include_once '../Models/TypeEval.class.php';
		include_once '../Models/UE.class.php';
		include_once '../Models/Etudiant.class.php';
		include_once '../Models/Classe.class.php';
		include_once '../Models/Etudier.class.php';
		include_once '../Models/Obtenir.class.php';
		include_once '../Models/Filiere.class.php';
		include_once '../Models/Niveau.class.php';

		foreach( Self::getClasseAllEtu($idClasse) as $etudiant ) {

			$moy = 0.0;
			$somCoef = 0;

			//$ues = UE::getAllUE((explode("-", $idClasse))[0]);
			$classeUES = UE::getClasseAllUE($idClasse);
			foreach($classeUES as $ue) {

				$moyUE = (UE::read($ue['idUE']))->getMoyUE($etudiant['idEtudiant']);

				//S'il y a un seul défaillant
				if($moyUE < 0){
					return -1;
				}
				
				$moy = $moy + $moyUE*$ue['coef'];

				$somCoef = $somCoef + $ue['coef'];
			}

			$moyAllEtudiant[] = $moy/$somCoef;
		}

		return $moyAllEtudiant;
	}

	public static function getPourcentEtu($idClasse, $validationTC, $validationSP) {

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

		$pourcent[] = "empty";

		foreach( Self::getClasseAllEtu($idClasse) as $etudiant ) {
			
			if($pourcent[0] == "empty") {
				unset($pourcent);
			}
			$coefV = 0;
			$somCoef = 0;

			$defaillant = false;
			$classeUES = UE::getClasseAllUE($idClasse);
			foreach($classeUES as $ue) {
				if( (UE::read($ue['idUE']))->getCodeTypeUE() == "TC") {
					$validation = $validationTC;
				}
				else {
					$validation = $validationSP;
				}
				
				$moyUE = (UE::read($ue['idUE']))->getMoyUE($etudiant['idEtudiant']);
				
				if($moyUE >=$validation) {
					$coefV = $coefV + $ue['coef'];
				}
				else if($moyUE < 0){//S'il y a un seul défaillant
					$defaillant = true;
				}

				$somCoef = $somCoef + $ue['coef'];
			}

			if(!$defaillant && $somCoef > 0) {
				$pourcent[] = ($coefV/$somCoef)*100;
			}
			else {//S'il y a un seul défaillant
				$pourcent[] =  -1;
			}
			
		}

		return $pourcent;
	}

	public function getPourcent($idClasse, $validationTC, $validationSP) {

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

			
			$coefV = 0;
			$somCoef = 0;

		$defaillant = false;
		$classeUES = UE::getClasseAllUE($idClasse);
		foreach($classeUES as $ue) {
			if( (UE::read($ue['idUE']))->getCodeTypeUE() == "TC") {
				$validation = $validationTC;
			}
			else {
				$validation = $validationSP;
			}
			
			$moyUE = (UE::read($ue['idUE']))->getMoyUE($this->getIdEtudiant());
			
			if($moyUE >=$validation) {
				$coefV = $coefV + $ue['coef'];
			}
			else if($moyUE < 0){//S'il y a un seul défaillant
				$defaillant = true;
			}

			$somCoef = $somCoef + $ue['coef'];
		}

		if(!$defaillant) {
			$pourcent = ($coefV/$somCoef)*100;
		}
		else {//S'il y a un seul défaillant
			$pourcent =  -1;
		}

		return $pourcent;
	}

	public function getCycleEtu(){
		$etudiant = $this->idEtudiant;
		include('../Database/database.php');

		$select = $bdd->query("SELECT cycle,libelleNiveau FROM Etudiant,Etudier,Classe,Niveau WHERE etudiant.idEtudiant=etudier.idEtudiant AND etudier.idClasse=classe.idClasse AND classe.idNiveau=niveau.idNiveau AND etudiant.idEtudiant='$etudiant' ");
		$result = $select->fetchAll();
		return $result[0];
	}

	public function findAnneeStart(){
		$etudiant = $this->matriculeEtu;
		include('../Database/database.php');

		$select = $bdd->query("SELECT idEtudiant FROM Etudiant WHERE matricule='$etudiant' ");

		include_once '../Models/AnneeAcademique.class.php';
		$min=(AnneeAcademique::encours())->getIdAnnee();
		if(!empty($select) && $select->rowCount()>=1){
			$result = $select->fetchAll();
			foreach ($result as $res) {
				$tab = explode('-', $res['idEtudiant']);
				if($tab[0] < $min){ $min = $tab[0]; }
			}
		}
		$start = $min[0]."".$min[1]."".$min[2]."".$min[3];
		return $start;
	}

	public static function genererIdEtudiant() {

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();

		$select = $bdd->query("SELECT * FROM etudiant");

		if(!empty($select) && $select->rowCount() == 0){
			$idEtudiant = ($encours)->getIdAnnee() .'-1';
		}
		else {

			$etudiants = Etudiant::getAllEtudiant($encours->getIdAnnee());

			foreach($etudiants as $etudiant) {
				$etuId[] =  (explode("-", $etudiant['idEtudiant']))[1] ;
			}
			$max = $etuId[0];
			
			for($i = 1; $i < count($etuId); $i++) {
				if($etuId[$i] > $max) {
					$max = $etuId[$i];
				}
			}
			$a = $max+1;
			$idEtudiant = (AnneeAcademique::encours())->getIdAnnee() .'-'.$a;
		}
		
		return $idEtudiant;
	}

}