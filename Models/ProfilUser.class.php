<?php
if(!isset($_SESSION))
		session_start();
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
			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = "Ajout effectué avec succès !";

		}else{	$_SESSION['alert'] = 'error';
			    $_SESSION['alert_message'] = "Ajout échoué : Ce Profil d'utilisateur existe déjà !";}
		
	}

	public static function read($codeProfil) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM profiluser WHERE codeProfil='$codeProfil' ");
		$aProfil = $select->fetchAll();
		if(!empty($aProfil)){
			$aProfils = new ProfilUser($aProfil[0][0], $aProfil[0][1]);
			return $aProfils;
		}else{
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Lecture échouée : Ce Profil d'utilisateur n'existe pas !";
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

				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = "Modification effectuée avec succès !";
			}	
			else{
					$select = $bdd->query("SELECT * FROM profiluser WHERE codeProfil='$newCodeProfil' ");
					if(!empty($select) && $select->rowCount() >=1) {
						$_SESSION['alert'] = 'error';
			   		    $_SESSION['alert_message'] = "Modification échouée : Ce Profil d'utilisateur existe déjà !";
					}
					else {
						$update = $bdd->prepare("UPDATE profiluser SET codeProfil=?, libelleProfil=? WHERE codeProfil='$codeProfil' ");
						$update->execute(array($newCodeProfil, $newLibProfil));

						$_SESSION['alert'] = 'success';
						$_SESSION['alert_message'] = "Modification effectuée avec succès !";
					}
				}
	}

	public function delete() {
		$codeProfil = $this->codeProfil;
		include('../Database/database.php');
		include_once '../Models/Utilisateur.class.php';

		$select = $bdd->query("SELECT * FROM profiluser WHERE codeProfil='$codeProfil' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Suppression échouée : Ce Profil d'utilisateur n'existe pas !";
		}
		else {	
			$select2 = $bdd->query("SELECT * FROM users WHERE codeProfil='$codeProfil' ");
			if(!empty($select2) && $select2->rowCount() == 0) {
				$delete = $bdd->exec("DELETE FROM profiluser WHERE codeProfil='$codeProfil' ");

				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = "Suppression effectuée avec succès !";
			}
			else {
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Suppression impossible : ce profil est déjà associé à des utilisateurs !';
			}
		}
	}

}