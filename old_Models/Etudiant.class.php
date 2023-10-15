<?php 

class Etudiant {

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

	function __construct($matriculeEtu,$nomEtu,$prenomEtu,$sexeEtu,$telephoneEtu,$dateNaissanceEtu,$lieuNaissanceEtu,$nationaliteEtu,$codeStatut) {

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

	public static function create($matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut) {
		
		include('../Database/database.php');

		$request1 = $bdd->query("SELECT * FROM statut");
		
		if(!empty($request1) && $request1->rowCount() == 0){
			print "Aucun statut n'existe pour le moment, veuillez en rajouter avant de poursuivre";
		} 
		else{
			
			$request2 = $bdd->query("SELECT * FROM statut WHERE codeStatut='$codeStatut'");
			
			$request3 = $bdd->query("SELECT * FROM etudiant WHERE matricule='$matriculeEtu'");
		
			if(!empty($request2) && $request2->rowCount() == 1){
	
				if(!empty($request3) && $request3->rowCount() == 0){
	
					$insertion = $bdd->prepare('INSERT INTO etudiant(matricule, nom, prenom, sexe, telephone, datenaissance, lieunaissance, nationalite, codeStatut) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)');
					$insertion->execute(array($matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut));
				}else{ print "Risque de doublon; Cet etudiant existe deja"; }
			}
			else{print "Ce statut n'existe pas dans la liste";}
		}
		
	}

	public static function read($matriculeEtu) {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudiant WHERE matricule='$matriculeEtu' ");
		$aEtudiant = $select->fetchAll();
		if(!empty($aEtudiant)) {
			$etudiant = new Etudiant($aEtudiant[0][0], $aEtudiant[0][1], $aEtudiant[0][2], $aEtudiant[0][3],$aEtudiant[0][4], $aEtudiant[0][5],$aEtudiant[0][6], $aEtudiant[0][7], $aEtudiant[0][8]);
			return $etudiant;
		}
		else {
			print "Statut introuvable !";
			return false;
		}
	}

	public static function getAllEtudiant() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM etudiant, etudier WHERE etudiant.matricule=etudier.matricule ORDER BY nom, prenom ASC");
		$allEtudiant = $select->fetchAll();
		return $allEtudiant;
	}

	public function update($matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut) {

		$matricule = $this->matriculeEtu;

		include('../Database/database.php');

		$select = $bdd->prepare("SELECT * FROM etudiant WHERE matricule=? AND nom=? AND prenom=? AND sexe=? AND telephone=? AND dateNaissance=? AND lieuNaissance=? AND nationalite=? AND codeStatut=? ");
		$select->execute(array($matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut));
		if(!empty($select) && $select->rowCount() >=1) {
			print "Modification échouée : risque de doublon. Ce matricule d'étudiant est déjà utilisé !";
		}
		else {
			$update = $bdd->prepare("UPDATE etudiant SET matricule=?, nom=?, prenom=?, sexe=?, telephone=?, dateNaissance=?, lieuNaissance=?, nationalite=?, codeStatut=? WHERE matricule='$matricule' ");
			$update->execute(array($matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut));

			print "L'étudiant a été modifié avec succès";
		}
	}

	public function delete() {

		$matriculeEtu = $this->matriculeEtu;

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudiant WHERE matricule='$matriculeEtu' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Cet étudiant n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM etudiant WHERE matricule='$matriculeEtu' ");

			print "L'étudiant a été supprimé";
		}
	}

	public static function getNbEtudiant() {

		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM etudiant");

		return $select->rowCount();
	}

}