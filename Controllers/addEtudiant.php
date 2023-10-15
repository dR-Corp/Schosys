<?php 
	if (isset($_POST['creer'])) {

		if(isset($_POST['statut']) && !empty($_POST['statut'])) {
			if(isset($_POST['classe']) && !empty($_POST['classe'])) {

				$matriculeEtu = htmlspecialchars($_POST['matricule']);
				$nomEtu = htmlspecialchars($_POST['nom']);
				$prenomEtu = htmlspecialchars($_POST['prenom']);
				$sexeEtu = htmlspecialchars($_POST['sexe']);
				$telephoneEtu = htmlspecialchars($_POST['telephone']);
				$dateNaissanceEtu = htmlspecialchars($_POST['datenaissance']);
				$lieuNaissanceEtu = htmlspecialchars($_POST['lieunaissance']);
				$nationaliteEtu = htmlspecialchars($_POST['nationalite']);
				$codeStatut = htmlspecialchars($_POST['statut']);
				$classe = htmlspecialchars($_POST['classe']);

				if (isset($matriculeEtu) && !empty($matriculeEtu) && isset($nomEtu) && !empty($nomEtu) && isset($prenomEtu) && !empty($prenomEtu) && isset($sexeEtu) && !empty($sexeEtu) && isset($telephoneEtu) && !empty($telephoneEtu) && isset($dateNaissanceEtu) && !empty($dateNaissanceEtu) && isset($lieuNaissanceEtu) && !empty($lieuNaissanceEtu) && isset($nationaliteEtu) && !empty($nationaliteEtu) && isset($codeStatut) && !empty($codeStatut) && isset($classe) && !empty($classe))
				{
					include_once '../Models/Etudiant.class.php';
					include_once '../Models/AnneeAcademique.class.php';
					include_once '../Models/Etudier.class.php';
					$annee = AnneeAcademique::encours();
					if($annee) {
						$idEtudiant = Etudiant::genererIdEtudiant();
						Etudiant::create($idEtudiant,$matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut);
						Etudier::create($classe, $idEtudiant, $annee->getIdAnnee());
					}
					else {
						print "<script>alert(\"L'année academique n'a pas encore commencé\")</script>";
					}
					header("Location:../View/etudiants.php");
				}
			}
			else {
				$_SESSION['alert'] = 'error';
				$_SESSION['alert_message'] = 'Ajout échoué : il n\'existe aucune classe !';
			}
		}
		else {
			$_SESSION['alert'] = 'error';
			$_SESSION['alert_message'] = 'Ajout échoué : il n\'existe aucun statut d\'étudiant !';
		}
		
	}
?>