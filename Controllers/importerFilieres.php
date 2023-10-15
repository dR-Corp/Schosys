<?php

if(isset($_GET['import'])) {
    include_once '../Models/Filiere.class.php';
    include_once '../Models/AnneeAcademique.class.php';

    $annee_encours = (AnneeAcademique::encours())->getIdAnnee();
    $annee_precedente = $annee_encours;
    $annee_precedente[3] = $annee_encours[3]-1;
    $annee_precedente[7] = $annee_encours[7]-1;

    $filieres  = Filiere::getAllFiliere($annee_precedente);

    foreach($filieres as $filiere) {
        $idFiliere = Filiere::genererIdFiliere();
        Filiere::create($idFiliere, $filiere['codeFiliere'], $filiere['libelleFiliere']);
    } 

    $_SESSION['alert'] = 'success';
    $_SESSION['alert_message'] = 'Importation effectuée avec succès !';
}

header("Location: ../View/filieres.php");

?>