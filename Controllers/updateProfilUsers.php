<?php
	if (isset($_GET['codeProfil'])) {
		$codeProfil = $_GET['codeProfil'];

		if (isset($_POST['modifier'])) {
			$newCodeProfil = htmlspecialchars($_POST['codeProfil']);
			$newLibelleProfil = htmlspecialchars($_POST['libelleProfil']);

			if (isset($newCodeProfil) && !empty($newCodeProfil) && isset($newLibelleProfil) && !empty($newLibelleProfil) ) {
				include '../Models/ProfilUser.class.php';
				$profil = ProfilUser::read($codeProfil);
				if ($profil) {
                    
					$profil->update($newCodeProfil, $newLibelleProfil);
				}
				header("Location:../View/profilUsers.php");
			}
		}
	}
?>