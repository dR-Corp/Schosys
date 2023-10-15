<?php 
	if (isset($_POST['creer'])) {
		$codeProfil = htmlspecialchars($_POST['codeProfil']);
		$libelleProfil = htmlspecialchars($_POST['libelleProfil']);
	
		if (isset($codeProfil) && !empty($codeProfil) && isset($libelleProfil) && !empty($libelleProfil) ) {
            
            include '../Models/ProfilUser.class.php';
            ProfilUser::create($codeProfil, $libelleProfil);
            
			header("Location:../View/profilUsers.php");
		}
		
	}
?>


