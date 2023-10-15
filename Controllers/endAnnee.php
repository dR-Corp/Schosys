<?php
    session_start();
    include_once '../Models/AnneeAcademique.class.php';
    $annee = AnneeAcademique::encours();
    if ($annee) {
        $annee->end();
        //$_SESSION['end'] = true;
    }
    header("Location:../View/annees.php");
    
?>