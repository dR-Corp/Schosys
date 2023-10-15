<?php
if(!isset($_SESSION))
		session_start();
class Utilisateur {
	
	//variables membres
	private $username; //nom d'utilisateur
	private $name;	//nom de l'utilisateur
	private $firstname; //prénom de l'utilisateur
	private $email; //adresse email de l'utilisateur
	private $password;	//mot de passe

	//Clé étrangère
	private $codeProfil; //code du profil de l'utilisateur

	//constructeur
	function __construct($username, $name, $firstname, $email, $password, $codeProfil) {

		$this->username = $username;
		$this->name = $name;
		$this->firstname = $firstname;
		$this->email = $email;
		$this->password = $password;
		$this->codeProfil = $codeProfil;
	}

	//username
	public function getUsername() {
		return $this->username;
	}
	public function setUsername($newUsername) {
		if(!empty($newUsername))
			$this->username = $newUsername;
	}

	//name
	public function getName() {
		return $this->name;
	}
	public function setName($newName) {
		if(!empty($newName))
			$this->name = $newName;
	}

	//firstname
	public function getfirstname() {
		return $this->firstname;
	}
	public function setFirstname($newFirstname) {
		if(!empty($newFirstname))
			$this->firstname = $newFirstname;
	}

	//email
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($newEmail) {
		if(!empty($newEmail) && (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $newEmail))) {
			$this->email = $newEmail;
		}
	}

	//On ne peut que modifier un mot de passe, pour raison de sécurité
	public function setPassword($newPassword) {
		if(!empty($newPassword))
			$this->password = $newPassword;
	}

	public static function create($username, $name, $firstname, $email, $password, $codeProfil) {

		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM users WHERE username='$username' ");
		$select1 = $bdd->query("SELECT * FROM profilUser WHERE codeProfil='$codeProfil' ");

		if(!empty($select) && $select->rowCount() == 0) {
			if(!empty($select1) && $select1->rowCount() >=1) {

				$insert = $bdd->prepare('INSERT INTO users(username, name,firstname, email, password, codeProfil) VALUES(?, ?, ?, ?, ?, ?)');
				$insert->execute(array($username, $name, $firstname, $email, $password, $codeProfil));

				include_once '../Models/ProfilUser.class.php';
				$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
				$eventsFile = fopen("../Uploads/utilisateur.txt", "a+");
				fputs($eventsFile, date('d/m/Y H:i:s')." Ajout d'utilisateur $username $name $firstname $email $codeProfil par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
				fclose($eventsFile);

				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = "Ajout effectué avec succès !";
			}
			else {
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = "Ajout échoué : Ce profil n'existe pas !";}
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Ajout échoué : Cet utilisateur existe déjà !";
		}
	}

	public static function getAllUsers() {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM users ");
		$allUsers = $select->fetchAll();
		return $allUsers;
	}

	public static function read($username) {
		include('../Database/database.php');
		$select = $bdd->query("SELECT * FROM users WHERE username='$username' ");
		$aUser = $select->fetchAll();
		if(!empty($aUser)){
		$aUsers = new Utilisateur($aUser[0][0], $aUser[0][1], $aUser[0][2], $aUser[0][3],$aUser[0][4],$aUser[0][5]);
			return $aUsers;
		}else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Lecture échouée : Cet Utilisateur n'existe pas !"; 
			return false;
		}
			
		}
	

	public function updatePwd($newUsername, $newName, $newFirstname, $newEmail, $newPassword, $newCodeProfil) {
		$usernam = $this->username;
		include('../Database/database.php');

		if($usernam == $newUsername){
			$update = $bdd->prepare("UPDATE users SET username=?, name=?, firstname=?, email=?, password=?, codeProfil=? WHERE username='$usernam' ");
			$update->execute(array($newUsername,$newName, $newFirstname, $newEmail, $newPassword, $newCodeProfil));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = "Modification effectuée avec succès !";
		}
		else{
				$select = $bdd->query("SELECT * FROM users WHERE username='$newUsername' ");
			if(!empty($select) && $select->rowCount() >=1) {
				$_SESSION['alert'] = 'error';
			    $_SESSION['alert_message'] = "Modification échouée : Cet Utilisateur existe déjà !";
			}else{
				$update = $bdd->prepare("UPDATE users SET username=?, name=?, firstname=?, email=?, password=?, codeProfil=? WHERE username='$usernam' ");
			$update->execute(array($newUsername,$newName, $newFirstname, $newEmail, $newPassword, $newCodeProfil));

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = "Modification effectuée avec succès !";
			}
		}
	}



	public function update($newUsername, $newName, $newFirstname, $newEmail, $newCodeProfil) {
		$usernam = $this->username;
		$name = $this->name;
		$firstname = $this->firstname;
		$email = $this->email;
		$codeProfil = $this->codeProfil;
		include('../Database/database.php');

		if($usernam == $newUsername){
			$update = $bdd->prepare("UPDATE users SET username=?, name=?, firstname=?, email=?, codeProfil=? WHERE username='$usernam' ");
			$update->execute(array($newUsername,$newName, $newFirstname, $newEmail, $newCodeProfil));

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/utilisateur.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Modification d'utilisateur ''$usernam $name $firstname $email $codeProfil'' en ''$newUsername $newName $newFirstname $newEmail $newCodeProfi'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = "Modification effectuée avec succès !";
		}
		else {
				$select = $bdd->query("SELECT * FROM users WHERE username='$newUsername' ");
			if(!empty($select) && $select->rowCount() >=1) {
				$_SESSION['alert'] = 'error';
			    $_SESSION['alert_message'] = "Modification échouée : Cet Utilisateur existe déjà !";
			}
			else {

				$update = $bdd->prepare("UPDATE users SET username=?, name=?, firstname=?, email=?, codeProfil=? WHERE username='$usernam' ");
				$update->execute(array($newUsername,$newName, $newFirstname, $newEmail, $newCodeProfil));

				include_once '../Models/ProfilUser.class.php';
				$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
				$eventsFile = fopen("../Uploads/utilisateur.txt", "a+");
				fputs($eventsFile, date('d/m/Y H:i:s')." Modification d'utilisateur ''$usernam $name $firstname $email $codeProfil'' en ''$newUsername $newName $newFirstname $newEmail $newCodeProfi'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
				fclose($eventsFile);

				$_SESSION['alert'] = 'success';
				$_SESSION['alert_message'] = "Modification effectuée avec succès !";
			}
		}
	}

	public function delete() {
		$username = $this->username;
		$name = $this->name;
		$firstname = $this->firstname;
		$email = $this->email;
		$codeProfil = $this->codeProfil;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM users WHERE username='$username' ");
		if(!empty($select) && $select->rowCount() == 0) {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = "Suppression échouée : Cet Utilisateur n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM users WHERE username='$username' ");

			include_once '../Models/ProfilUser.class.php';
			$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
			$eventsFile = fopen("../Uploads/utilisateur.txt", "a+");
			fputs($eventsFile, date('d/m/Y H:i:s')." Suppression d'utilisateur ''$username $name $firstname $email $codeProfil'' par $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
			fclose($eventsFile);

			$_SESSION['alert'] = 'success';
			$_SESSION['alert_message'] = "Suppression effectuée avec succès !";
		}
	}

	//envoyer un email à l'utilisateur
	public function envoyerEmail($objet, $message) {

		$header = "MIME-Version: 1.0\r\n";
		$header .= 'From:"dR.com"<support@dR.com>'."\n";
		$header .= 'Content-Type:text/html; charset="utf-8"'."\n";
		$header .= 'Content-Transfert-Encoding: 8bit';

		if(mail($this->email, $objet, $message, $header)) {
			print "Email envoyé";
		}
		else {
			print "an error occur";
		}
	}
}
