<?php
    session_start();
    if (isset($_GET['idAnnee'])) {
		$idAnnee = $_GET['idAnnee'];

        include_once '../Models/AnneeAcademique.class.php';
        $encours = AnneeAcademique::encours();
        $annee = AnneeAcademique::read($idAnnee);
        if (!$encours) {
            $annee->start();
            //$_SESSION['start'] = true;
            // $_SESSION['idAnnee'] = $annee->getIdAnnee();
            // $_SESSION['annee'] = $annee->getAnnee();
        }
    }
    header("Location:../View/annees.php");
?>