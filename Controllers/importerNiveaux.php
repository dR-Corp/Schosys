<?php

if(isset($_GET['import'])) {
    include_once '../Models/Niveau.class.php';
    include_once '../Models/AnneeAcademique.class.php';

    $annee_encours = (AnneeAcademique::encours())->getIdAnnee();
    $annee_precedente = $annee_encours;
    $annee_precedente[3] = $annee_encours[3]-1;
    $annee_precedente[7] = $annee_encours[7]-1;

    $niveaux  = Niveau::getAllNiveau($annee_precedente);

    foreach($niveaux as $niveau) {
        $idniveau = Niveau::genererIdNiveau();
        Niveau::create($idniveau, $niveau['codeNiveau'], $niveau['libelleNiveau'], $niveau['duree'], $niveau['cycle']);
    }

    $_SESSION['alert'] = 'success';
    $_SESSION['alert_message'] = 'Importation effectuée avec succès !';
}

header("Location: ../View/niveaux.php");

?>