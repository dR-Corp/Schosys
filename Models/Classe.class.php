<?php
	if(!isset($_SESSION))
		session_start();
class Classe {

	private $idClasse;
	private $codeClasse;
	private $libClasse;
	private $validationTC;
	private $validationSP;

	//Clés étrangères
	private $idNiveau;
	private $idFiliere;

	function __construct($idClasse,$codeClasse,$libClasse,$idNiveau,$idFiliere,$validationTC,$validationSP) {

		$this->idClasse = $idClasse;
		$this->codeClasse = $codeClasse;
		$this->libClasse = $libClasse;
		$this->idNiveau = $idNiveau;
		$this->idFiliere = $idFiliere;
		$this->validationTC = $validationTC;
		$this->validationSP = $validationSP;

	}

	public function getIdClasse() {
		return $this->idClasse;
	}
	public function setIdClasse($newIdClasse) {
		if(!empty($newIdClasse))
			$this->idClasse = $newIdClasse;
	}

	public function getCodeClasse() {
		return $this->codeClasse;
	}
	public function setCodeClasse($newCodeClasse) {
		if(!empty($newCodeClasse))
			$this->codeClasse = $newCodeClasse;
	}

	public function getLibClasse() {
		return $this->libClasse;
	}
	
	public function setLibClasse($newLibClasse) {
		if(!empty($newLibClasse))
			$this->libClasse = $newLibClasse;
	}
	public function getIdFiliere() {
		return $this->idFiliere;
	}
	public function getIdNiveau() {
		return $this->idNiveau;
	}

	public function getValidationTC() {
		return $this->validationTC;
	}
	public function setValidationTC($newValidationTC) {
		if(!empty($newValidationTC)) {

			$idClasse = $this->idClasse;
			include('../Database/database.php');
			include_once '../Models/AnneeAcademique.class.php';

			$update = $bdd->prepare("UPDATE classe SET validationTC=? WHERE idClasse='$idClasse' ");
			$update->execute(array($newValidationTC));
			$this->validationTC = $newValidationTC;
			
			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajustement effectuée avec succès !';

		}
	}

	public function getValidationSP() {
		return $this->validationSP;
	}
	public function setValidationSP($newValidationSP) {
		if(!empty($newValidationSP)) {

			$idClasse = $this->idClasse;
			include('../Database/database.php');
			include_once '../Models/AnneeAcademique.class.php';

			$update = $bdd->prepare("UPDATE classe SET validationSP=? WHERE idClasse='$idClasse' ");
			$update->execute(array($newValidationSP));
			$this->validationSP = $newValidationSP;

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Ajustement effectuée avec succès !';
		}
	}

	public static function create($idClasse, $codeClasse, $libClasse, $idNiveau, $idFiliere) {
		
		include("../Database/database.php");

		include_once '../Models/AnneeAcademique.class.php';
		include_once '../Models/Etudiant.class.php';
		include_once '../Models/Niveau.class.php';
		include_once '../Models/ProfilUser.class.php';

		$encours = (AnneeAcademique::encours())->getIdAnnee();
		
		$select1 = $bdd->query("SELECT * FROM niveau WHERE idNiveau='$idNiveau'");
		$select2 = $bdd->query("SELECT * FROM filiere WHERE idFiliere='$idFiliere'");
		$select3 = $bdd->query("SELECT * FROM classe WHERE idClasse LIKE '$encours%' AND codeClasse='$codeClasse'");
		$select4 = $bdd->query("SELECT * FROM anneeacad");
		
		if(!empty($select1) && $select1->rowCount()>=1){

			if(!empty($select2) && $select2->rowCount()>=1){

				if(!empty($select3) && $select3->rowCount() == 0) {

					$insert = $bdd->prepare("INSERT INTO classe(idClasse,codeClasse,libelleClasse,idNiveau,idFiliere) VALUES(?,?,?,?,?)");
					$insert->execute(array($idClasse,$codeClasse,$libClasse,$idNiveau,$idFiliere));

					$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
					$eventsFile = fopen("../Uploads/classe.txt", "a+");
					fputs($eventsFile, date('d/m/Y H:i:s')." Ajout de classe '' $idClasse $codeClasse $libClasse '' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
					fclose($eventsFile);

					if(!empty($select4) && $select4->rowCount() > 1) {

						$dec = explode("-",$codeClasse);
						if($dec[2] > 1) {

							$codeClassePrevInf = $dec[0]."-".$dec[1]."-".($dec[2]-1);
							$tofind = Classe::findCodeClasseObject($codeClassePrevInf, AnneeAcademique::anneePassee()->getIdAnnee());
							if($tofind) {	
								$idClassePrevInf = ($tofind)->getIdClasse();
								$classePrevInfObject = Classe::read($idClassePrevInf);
								$etudiantDeLaClasseA = Etudiant::getClasseAllEtu($idClassePrevInf);

								foreach($etudiantDeLaClasseA as $etu) {
									$pourcent = (Etudiant::read($etu['idEtudiant']))->getPourcent($idClassePrevInf, $classePrevInfObject->getValidationTC(), $classePrevInfObject->getValidationSP());
									if($pourcent >= 85 ) {
										$annee = AnneeAcademique::encours();
										if($annee) {
											$idEtu = Etudiant::genererIdEtudiant();
											Etudiant::create($idEtu,$etu['matricule'], $etu['nom'], $etu['prenom'], $etu['sexe'], $etu['telephone'], $etu['datenaissance'], $etu['lieunaissance'], $etu['nationalite'], "PSST");
											Etudier::create($idClasse, $idEtu, $annee->getIdAnnee());
										}
									}
								}
							}
						}

						// $idAncienneClasse = (Classe::findClasseId($codeClasse))->getIdClasse();
						$c = Classe::findCodeClasseObject($codeClasse, AnneeAcademique::anneePassee()->getIdAnnee());
						if($c) {
							$idAncienneClasse = $c->getIdClasse();
							$etudiantDeLaClasse = Etudiant::getClasseAllEtu($idAncienneClasse);
							$classePrevObject = Classe::read($idAncienneClasse);

							foreach($etudiantDeLaClasse as $etu) {
								$pourcent = (Etudiant::read($etu['idEtudiant']))->getPourcent($idAncienneClasse, $classePrevObject->getValidationTC(), $classePrevObject->getValidationSP());
								$duree = (Niveau::read($idNiveau))->getDuree();
								if( ($dec != $duree && $pourcent < 85 ) || ($dec == $duree && $pourcent < 100 ) ) {
									$annee = AnneeAcademique::encours();
									if($annee) {
										$idEtu = Etudiant::genererIdEtudiant();
										Etudiant::create($idEtu,$etu['matricule'], $etu['nom'], $etu['prenom'], $etu['sexe'], $etu['telephone'], $etu['datenaissance'], $etu['lieunaissance'], $etu['nationalite'], "RDBT");
										Etudier::create($idClasse, $idEtu, $annee->getIdAnnee());
									}
								}
							}
						}
					}
					$_SESSION['alert'] = 'success';
					$_SESSION['alert_message'] = 'Ajout effectué avec succès !';

				}
				else{
					$_SESSION['alert'] = 'error';
					$_SESSION['alert_message'] = 'Ajout échoué : cette classe existe déjà !';
				}

			}
			else{
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Ajout échoué : cette filiere n\'existe pas !';
			}

		}
		else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : ce niveau n\'existe pas !';
		}

	}

	public static function read($idClasse) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe WHERE idClasse='$idClasse' ");
		$aClasse = $select->fetchAll();
		if(!empty($aClasse)) {
			$classe = new Classe($aClasse[0][0], $aClasse[0][1],$aClasse[0][2], $aClasse[0][3], $aClasse[0][4], $aClasse[0][5], $aClasse[0][6]);
			return $classe;
		}
		else {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cette classe n\'existe pas !';
			return false;
		}
	}

	public static function findClasseId($codeClasse) {
		include('../Database/database.php');

		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();
		if($encours) {
			$annee = $encours->getIdAnnee();
		}
		
		$select = $bdd->query("SELECT * FROM classe WHERE idClasse LIKE '$annee%' AND codeClasse='$codeClasse' ");
		$aClasse = $select->fetchAll();
		if(!empty($aClasse)) {
			$classe = new Classe($aClasse[0][0], $aClasse[0][1],$aClasse[0][2], $aClasse[0][3], $aClasse[0][4], $aClasse[0][5], $aClasse[0][6]);
			return $classe;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cette classe n\'existe pas !';
			return false;
		}
	}

	public static function findCodeClasseObject($codeClasse, $annee) {
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe WHERE idClasse LIKE '$annee%' AND codeClasse='$codeClasse' ");
		$aClasse = $select->fetchAll();
		if(!empty($aClasse)) {
			$classe = new Classe($aClasse[0][0], $aClasse[0][1],$aClasse[0][2], $aClasse[0][3], $aClasse[0][4], $aClasse[0][5], $aClasse[0][6]);
			return $classe;
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cette classe n\'existe pas !';
			return false;
		}
	}

	public static function findClasseFIliere($idClasse) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe,filiere WHERE classe.idFiliere=filiere.idFiliere AND classe.idClasse='$idClasse' ");
		$aClasse = $select->fetchAll();
		if(!empty($aClasse)) {
			$filiere = $aClasse[0][4];
			return $filiere;
		}
		else {

			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Lecture échouée : cette classe n\'existe pas !';
			return false;
		}
	}

	public static function getAllClasse($annee) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe WHERE idClasse LIKE '$annee%' ORDER BY codeClasse");
		$allClasse = $select->fetchAll();
		return $allClasse;
	}

	public static function getAllClasseFiliere($annee, $idFiliere) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe, filiere WHERE classe.idFiliere=filiere.idFiliere AND classe.idClasse LIKE '$annee%' AND filiere.idFiliere='$idFiliere' ORDER BY codeClasse");
		$allClasse = $select->fetchAll();
		return $allClasse;
	}

	public static function getAllClasseNiveau($annee, $idNiveau) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe, niveau WHERE  classe.idNiveau=niveau.idNiveau AND classe.idClasse LIKE '$annee%' AND niveau.idNiveau='$idNiveau' ORDER BY codeClasse");
		$allClasse = $select->fetchAll();
		return $allClasse;
	}

	public static function getAllClasseAnneeNiveau($annee, $idNiveau) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe, niveau WHERE  classe.idNiveau=niveau.idNiveau AND classe.codeClasse LIKE '%$annee' AND niveau.idNiveau='$idNiveau' ORDER BY codeClasse");
		$allClasse = $select->fetchAll();
		return $allClasse;
	}

	public static function getAllClasseFiliereNiveau($annee, $idFiliere, $idNiveau) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM classe, filiere, niveau WHERE classe.idFiliere=filiere.idFiliere AND classe.idNiveau=niveau.idNiveau AND classe.idClasse LIKE '$annee%' AND niveau.idNiveau='$idNiveau' AND filiere.idFiliere='$idFiliere' ORDER BY codeClasse");
		$allClasse = $select->fetchAll();
		return $allClasse;
	}

	public static function getAllEtu_Classe($idClasse,$annee){
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudiant, etudier WHERE etudiant.idEtudiant=etudier.idEtudiant AND etudier.idClasse='$idClasse' AND idAnnee='$annee' ");
		//var_dump($select->fetchAll());

    	if(!empty($select) && $select->rowCount() != 0){
    		$mesEtu = $select->fetchAll();
    	}else{
    		$mesEtu[]='';
    	}
        return $mesEtu;	
	}

	public function delete() {

		$idClasse = $this->idClasse;
		$codeClasse = $this->codeClasse;
		$libClasse = $this->libClasse;
		include('../Database/database.php');
		include_once '../Models/ProfilUser.class.php';

		$select = $bdd->query("SELECT * FROM classe WHERE idClasse='$idClasse' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Suppression échouée : cette classe n\'existe pas !';
		}
		else {
			$delete = $bdd->exec("DELETE FROM classe WHERE idClasse='$idClasse' ");
			
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/classe.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Suppression de la classe '' $idClasse $codeClasse $libClasse '' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);
			
			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Suppression effectuée avec succès !';
		
		}
	}

	public function update($newCodeClasse, $newLibClasse, $newIdNiveau, $newIdFiliere) {

		$idClasse = $this->idClasse;
		$codeClasse = $this->codeClasse;
		$libClasse = $this->libClasse;
		include('../Database/database.php');
		
		include_once '../Models/ProfilUser.class.php';
		include_once '../Models/AnneeAcademique.class.php';
		$encours = (AnneeAcademique::encours())->getIdAnnee();
		$select3 = $bdd->query("SELECT * FROM classe WHERE idClasse LIKE '$encours%' AND codeClasse='$newCodeClasse'");
		
		if($codeClasse !=$newCodeClasse && !empty($select3) && $select3->rowCount() > 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Modification échouée : cette classe existe déjà !';
		}
		else {
			$update = $bdd->prepare("UPDATE classe SET codeClasse=?, libelleClasse=?, idNiveau=?, idFiliere=? WHERE idClasse='$idClasse' ");
			$update->execute(array($newCodeClasse, $newLibClasse, $newIdNiveau, $newIdFiliere));

			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/classe.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification de la classe '' $idClasse $codeClasse $libClasse '' '' en $idClasse $newCodeClasse $newLibClasse  ''  par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = 'Modifiation effectuée avec succès !';
		}	
	}

	public static function getNbClasse($annee) {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM classe WHERE idClasse LIKE '$annee%'");

		return $select->rowCount();
	}

	public function getTauxReussite($validationTC, $validationSP) {

		include('../Database/database.php');
		include_once '../Models/Etudiant.class.php';
		include_once '../Models/Etudier.class.php';
		include_once '../Models/Niveau.class.php';
		include_once '../Models/Classe.class.php';

		$idClasse =  $this->idClasse;
		$codeClasse =  $this->codeClasse;
		$etudiants = Etudiant::getClasseNbEtu($idClasse);
		$etudiantsAdmi = 0;
		
		foreach(Etudiant::getPourcentEtu($idClasse, $validationTC, $validationSP) as $pourcent) {

			$class = explode("-", $codeClasse);
			$duree = Niveau::read((Classe::read($idClasse))->getIdNiveau())->getDuree();
			
			if(is_numeric($pourcent)) {
				if($class[2] == $duree) {
					if($pourcent == 100): $etudiantsAdmi = $etudiantsAdmi + 1; endif;
				}
				else {
					if($pourcent >= 85): $etudiantsAdmi = $etudiantsAdmi + 1; endif;
				}
			}

		}
		if($etudiants > 0)
			$taux = ($etudiantsAdmi/$etudiants)*100;
		else
			$taux = 0;
		return $taux;
	}

	public function getAdmisSansReprise($validationTC, $validationSP) {

		include('../Database/database.php');
		include_once '../Models/Etudiant.class.php';
		include_once '../Models/Etudier.class.php';
		include_once '../Models/Niveau.class.php';
		include_once '../Models/Classe.class.php';

		$idClasse =  $this->idClasse;
		$codeClasse =  $this->codeClasse;
		$etudiants = Etudiant::getClasseNbEtu($idClasse);
		$admisSansReprise = 0;

		foreach(Etudiant::getPourcentEtu($idClasse, $validationTC, $validationSP) as $pourcent) {
			$class = explode("-", $codeClasse);
			$duree = Niveau::read((Classe::read($idClasse))->getIdNiveau())->getDuree();
			
			if(is_numeric($pourcent)) {
				if($class[2] != $duree) {
					if($pourcent == 100): $admisSansReprise += 1; endif;
				}
			}
		}
		return $admisSansReprise;
	}

	public function getAdmisAvecReprise($validationTC, $validationSP) {

		include('../Database/database.php');
		include_once '../Models/Etudiant.class.php';
		include_once '../Models/Etudier.class.php';
		include_once '../Models/Niveau.class.php';
		include_once '../Models/Classe.class.php';

		$idClasse =  $this->idClasse;
		$codeClasse =  $this->codeClasse;
		$etudiants = Etudiant::getClasseNbEtu($idClasse);
		$admisAvecReprise = 0;

		foreach(Etudiant::getPourcentEtu($idClasse, $validationTC, $validationSP) as $pourcent) {
			$class = explode("-", $codeClasse);
			$duree = Niveau::read((Classe::read($idClasse))->getIdNiveau())->getDuree();

			if(is_numeric($pourcent)) {
				if($class[2] != $duree) {
					if($pourcent >= 85 && $pourcent < 100): $admisAvecReprise += 1; endif;
				}
			}
		}
		return $admisAvecReprise;
	}

	public function getRefuses($validationTC, $validationSP) {

		include('../Database/database.php');
		include_once '../Models/Etudiant.class.php';
		include_once '../Models/Etudier.class.php';
		include_once '../Models/Niveau.class.php';
		include_once '../Models/Classe.class.php';

		$idClasse =  $this->idClasse;
		$codeClasse =  $this->codeClasse;
		$etudiants = Etudiant::getClasseNbEtu($idClasse);
		$refuse = 0;
		
		foreach(Etudiant::getPourcentEtu($idClasse, $validationTC, $validationSP) as $pourcent) {
			$class = explode("-", $codeClasse);
			$duree = Niveau::read((Classe::read($idClasse))->getIdNiveau())->getDuree();
			
			if(is_numeric($pourcent)) {
				if($class[2] != $duree) {
					if($pourcent >= 0 && $pourcent < 85): $refuse += 1; endif;
				}
				else {
					if($pourcent >= 0 && $pourcent < 100): $refuse += 1; endif;
				}
			}
		}
		return $refuse;
	}

	public static function genererIdClasse() {

		include('../Database/database.php');
		include_once '../Models/AnneeAcademique.class.php';
		$encours = AnneeAcademique::encours();

		$select = $bdd->query("SELECT * FROM classe");

		if(!empty($select) && $select->rowCount() == 0){
			$idClasse = ($encours)->getIdAnnee() .'-1';
		}
		else {

			$classes = Classe::getAllClasse($encours->getIdAnnee());
			if(!empty($classes)) {
				foreach($classes as $classe) {
					$classeId[] =  (explode("-", $classe['idClasse']))[1] ;
				}
				$max = $classeId[0];
				
				for($i = 1; $i < count($classeId); $i++) {
					if($classeId[$i] > $max) {
						$max = $classeId[$i];
					}
				}
				$a = $max+1;
				$idClasse = $encours->getIdAnnee() .'-'.$a;
			}
			else {
				$a = 1;
				$idClasse = $encours->getIdAnnee() .'-'.$a;
			}
		}
		
		return $idClasse;
	}

}