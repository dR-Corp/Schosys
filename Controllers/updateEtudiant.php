<?php
	if (isset($_GET['idEtudiant']) && isset($_GET['classe'])) {
		$idEtudiant = $_GET['idEtudiant'];
		$classe = $_GET['classe'];

		if (isset($_POST['modifier'])) {

			$matriculeEtu = htmlspecialchars($_POST['matricule']);
			$nomEtu = htmlspecialchars($_POST['nom']);
			$prenomEtu = htmlspecialchars($_POST['prenom']);
			$sexeEtu = htmlspecialchars($_POST['sexe']);
			$telephoneEtu = htmlspecialchars($_POST['telephone']);
			$dateNaissanceEtu = htmlspecialchars($_POST['datenaissance']);
			$lieuNaissanceEtu = htmlspecialchars($_POST['lieunaissance']);
			$nationaliteEtu = htmlspecialchars($_POST['nationalite']);
			$codeStatut = htmlspecialchars($_POST['statut']);
			$newClasse = htmlspecialchars($_POST['classe']);

			if (isset($matriculeEtu) && !empty($matriculeEtu) && isset($nomEtu) && !empty($nomEtu) && isset($prenomEtu) && !empty($prenomEtu) && isset($sexeEtu) && !empty($sexeEtu) && isset($telephoneEtu) && !empty($telephoneEtu) && isset($dateNaissanceEtu) && !empty($dateNaissanceEtu) && isset($lieuNaissanceEtu) && !empty($lieuNaissanceEtu) && isset($nationaliteEtu) && !empty($nationaliteEtu) && isset($codeStatut) && !empty($codeStatut)  && isset($newClasse) && !empty($newClasse))
			{
				
				include_once '../Models/Etudiant.class.php';
				include_once '../Models/AnneeAcademique.class.php';
				include_once '../Models/Etudier.class.php';
				$annee = AnneeAcademique::encours();
				if($annee) {
					$etudiant = Etudiant::read($idEtudiant);
					if ($etudiant) {
						$etudiant->update($matriculeEtu, $nomEtu, $prenomEtu, $sexeEtu, $telephoneEtu, $dateNaissanceEtu, $lieuNaissanceEtu, $nationaliteEtu, $codeStatut);
						
						$etudier = Etudier::read($classe, $idEtudiant, $annee->getIdAnnee());
						$etudier->update($newClasse, $idEtudiant, $annee->getIdAnnee());
					}
				}
				else {
					print "<script>alert(\"L'année academique n'a pas encore commencé\")</script>";
				}

				header("Location:../View/etudiants.php");
			}
		}
	}
?>