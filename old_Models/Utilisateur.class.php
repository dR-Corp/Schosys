<?php

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
			if(!empty($select1) && $select1->rowCount() >=1){
				$insert = $bdd->prepare('INSERT INTO users(username, name,firstname, email, password, codeProfil) VALUES(?, ?, ?, ?, ?, ?)');
				$insert->execute(array($username, $name, $firstname, $email, $password, $codeProfil));
				print "L'utilisaterur a été créé";
			}else{print "Ce profil n'existe pas !";}
		}else {print "Ce nom d'utilisateur est déjà utilisé";}
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
			print "Utilisateur introuvable !";
			return false;
		}
			
		}
	

	public function updatePwd($newUsername, $newName, $newFirstname, $newEmail, $newPassword, $newCodeProfil) {
		$usernam = $this->username;
		include('../Database/database.php');

		if($usernam == $newUsername){
			$update = $bdd->prepare("UPDATE users SET username=?, name=?, firstname=?, email=?, password=?, codeProfil=? WHERE username='$usernam' ");
			$update->execute(array($newUsername,$newName, $newFirstname, $newEmail, $newPassword, $newCodeProfil));

			print "L'utilisaterur a été modifié";
		}
		else{
				$select = $bdd->query("SELECT * FROM users WHERE username='$newUsername' ");
			if(!empty($select) && $select->rowCount() >=1) {
				print "Modification échouée. Ce username est déjà utilisé !";
			}else{
				$update = $bdd->prepare("UPDATE users SET username=?, name=?, firstname=?, email=?, password=?, codeProfil=? WHERE username='$usernam' ");
			$update->execute(array($newUsername,$newName, $newFirstname, $newEmail, $newPassword, $newCodeProfil));

			print "L'utilisaterur a été modifié";
			}
		}
	}



	public function update($newUsername, $newName, $newFirstname, $newEmail, $newCodeProfil) {
		$usernam = $this->username;
		include('../Database/database.php');

		if($usernam == $newUsername){
			$update = $bdd->prepare("UPDATE users SET username=?, name=?, firstname=?, email=?, codeProfil=? WHERE username='$usernam' ");
			$update->execute(array($newUsername,$newName, $newFirstname, $newEmail, $newCodeProfil));

			print "L'utilisaterur a été modifié";
		}
		else{
				$select = $bdd->query("SELECT * FROM users WHERE username='$newUsername' ");
			if(!empty($select) && $select->rowCount() >=1) {
				print "Modification échouée. Ce username est déjà utilisé !";
			}else{
				$update = $bdd->prepare("UPDATE users SET username=?, name=?, firstname=?, email=?, codeProfil=? WHERE username='$usernam' ");
			$update->execute(array($newUsername,$newName, $newFirstname, $newEmail, $newCodeProfil));

			print "L'utilisaterur a été modifié";
			}
		}
	}

	public function delete() {
		$username = $this->username;
		include('../Database/database.php');

		$select = $bdd->query("SELECT * FROM users WHERE username='$username' ");
		if(!empty($select) && $select->rowCount() == 0) {
			print "Suppression échouée. Ce t'utilisateur n'existe pas !";
		}
		else {	
			$delete = $bdd->exec("DELETE FROM users WHERE username='$username' ");

			print "L'utilisaterur a été supprimé";
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
