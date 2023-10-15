<?php

class profiluser {

	private $codeProfil;
	private $libProfil;

	function __construct($codeProfil,$libProfil) {

		$this->codeProfil=$codeProfil;
		$this->libProfil=$libProfil;

	}

	public function getCodeProfil() {
		return $this->codeProfil;
	}
	public function setCodeProfil($newCodeProfil) {
		if(!empty($newCodeProfil))
			$this->codeProfil = $newCodeProfil;
	}

	public function getLibProfil() {
		return $this->libProfil;
	}
	public function setLibProfil($newLibProfil) {
		if(!empty($newLibProfil))
			$this->libProfil = $newLibProfil;
	}

	public static function create($codeProfil, $libProfil) {
		
		include("../Database/database.php");
		$select = $bdd->query("SELECT * FROM profiluser WHERE codeProfil ='$codeProfil'");

		if(!empty($select) && $select->rowCount()==0){
			
			$insert=$bdd->prepare("INSERT INTO profiluser(codeProfil,libelleProfil) VALUES(?,?)");
			$insert->execute(array($codeProfil,$libProfil));

		}else{print "Ce profil d'utilisateur existe deja";}
		
	}

	public static function read($codeProfil) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM profiluser WHERE codeProfil='$codeProfil' ");
		$aProfil = $select->fetchAll();
		if(!empty($aProfil)){
			$aProfils = new ProfilUser($aProfil[0][0], $aProfil[0][1]);
			return $aProfils;
		}else{
			print "Profil introuvable";
			return false;
		}	
	}

	public static function getAllProfil() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM profiluser ");
		$allProfil = $select->fetchAll();
		return $allProfil;
	}

	public function update($newCodeProfil, $newLibProfil) {
		$codeProfil = $this->codeProfil;

		include('../Database/database.php');
			if($codeProfil == $newCodeProfil){	
				$update = $bdd->prepare("UPDATE profiluser SET codeProfil=?, libelleProfil=? WHERE codeProfil='$codeProfil' ");
				$update->execute(array($newCodeProfil, $newLibProfil));

				print "Le profil a été modifié avec succès";
			}	
			else{
					$select = $bdd->query("SELECT * FROM profiluser WHERE codeProfil='$newCodeProfil' ");
					if(!empty($select) && $select->rowCount() >=1) {
						print "Modification échouée : risque de doublon. Ce profil d'utilisateur est déjà utilisé !";
					}
					else {
						$update = $bdd->prepare("UPDATE profiluser SET codeProfil=?, libelleProfil=? WHERE codeProfil='$codeProfil' ");
						$update->execute(array($newCodeProfil, $newLibProfil));

						print "Le profil a été modifié avec succès";
					}
				}
	}

	public function delete() {
		$codeProfil = $this->codeProfil;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM profiluser WHERE codeProfil='$codeProfil' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Ce profil n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM profiluser WHERE codeProfil='$codeProfil' ");

			print "Le profil a été supprimé";
		}
	}

}