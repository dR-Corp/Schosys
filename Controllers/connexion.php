<?php

session_start();

include("../Database/database.php");

if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) 
{
	$res = $bdd->prepare("SELECT * FROM users WHERE username=? AND password=? ");
	$res->execute(array($_POST["username"], $_POST["password"]));
	$donnees=$res->fetch();

	if (!empty($donnees))
	{
		include_once '../Models/AnneeAcademique.class.php';
		$_SESSION["username"]=$donnees["username"];
		$_SESSION["name"]=$donnees["name"];
		$_SESSION["firstname"]=$donnees["firstname"];
		$_SESSION["email"]=$donnees["email"];
		$_SESSION["codeProfil"]=$donnees["codeProfil"];
		$_SESSION['alert'] = "success";
		$_SESSION['alert_message'] = "Bienvenue";
		if(AnneeAcademique::encours())
			$_SESSION['anneeAcad'] = (AnneeAcademique::encours())->getIdAnnee();
		include_once '../Models/ProfilUser.class.php';
		$prof = (ProfilUser::read($_SESSION['codeProfil']))->getLibProfil();
		$eventsFile = fopen("../Uploads/log.txt", "a+");
		fputs($eventsFile, date('d/m/Y H:i:s')." connexion $prof ".$_SESSION['name']." ".$_SESSION['firstname']." \n");
		fclose($eventsFile);
		header("Location: ../index.php");
		exit();
	}

	else
	{
		$_SESSION["echec"]="echec";
        header("Location: ../index.php");
		exit();
	}
}
else {
    $_SESSION["empty"]="empty";
    header("Location: ../index.php");
	exit();
}
?>

