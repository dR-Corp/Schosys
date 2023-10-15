<?php

if(isset($_GET['import'])) {
    include_once '../Models/Classe.class.php';
    include_once '../Models/AnneeAcademique.class.php';
    include_once '../Models/Filiere.class.php';
    include_once '../Models/Niveau.class.php';

    $annee_encours = (AnneeAcademique::encours())->getIdAnnee();
    $annee_precedente = $annee_encours;
    $annee_precedente[3] = $annee_encours[3]-1;
    $annee_precedente[7] = $annee_encours[7]-1;

    $classes  = Classe::getAllClasse($annee_precedente);

    foreach($classes as $classe) {

        $codeFiliere = (Filiere::read($classe['idFiliere']))->getCodeFiliere();
        $codeNiveau = (Niveau::read($classe['idNiveau']))->getCodeNiveau();
        
        if(Filiere::findFiliereId($codeFiliere)) {
            if(Niveau::findNiveauId($codeNiveau)) {
                
                $idClasse = Classe::genererIdClasse();
                $idFiliere = (Filiere::findFiliereId($codeFiliere))->getIdFiliere();
                $idNiveau = (Niveau::findNiveauId($codeNiveau))->getIdNiveau();
                Classe::create($idClasse, $classe['codeClasse'], $classe['libelleClasse'], $idNiveau, $idFiliere);
                
                $_SESSION['alert'] = 'success';
                $_SESSION['alert_message'] = 'Importation effectuée avec succès !';
            }
            else {
                $_SESSION['alert'] = 'error';
                $_SESSION['alert_message'] = 'Importation echouée :  certains niveaux n\'existent pas encore !';
                break;
            }
        }
        else {
            $_SESSION['alert'] = 'error';
            $_SESSION['alert_message'] = 'Importation echouée :  certaines filières n\'existent pas encore !';
            break;
        }
    }

}

header("Location: ../View/classes.php");

?>