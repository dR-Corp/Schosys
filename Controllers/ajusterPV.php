<?php

    if(isset($_GET['anneeSimulation']) && isset($_GET['niveauSimulation']) && isset($_GET['ueTC']) && isset($_GET['ueSP']) && isset($_GET['classeSimulation'])) {

        include_once '../Models/Evaluation.class.php';
        include_once '../Models/ClasseUE.class.php';
        include_once '../Models/TypeEval.class.php';
        include_once '../Models/ECU.class.php';
        include_once '../Models/Etudiant.class.php';
        include_once '../Models/Classe.class.php';
        include_once '../Models/AnneeAcademique.class.php';
        include_once '../Models/Etudier.class.php';
        include_once '../Models/Obtenir.class.php';
        include_once '../Models/Filiere.class.php';
        include_once '../Models/Niveau.class.php';
        include_once '../Models/UE.class.php';

        $anneeSimulation = $_GET['anneeSimulation'];

        $niveauSimulation = $_GET['niveauSimulation'];

        $classeSimulation = $_GET['classeSimulation'];
        
        $encours = (AnneeAcademique::encours())->getIdAnnee();

        if(empty($classeSimulation)) {
            $allClasses = Classe::getAllClasseNiveau($encours, $niveauSimulation);
            foreach($allClasses as $classe) {
                $chiffre = explode("-", ((Classe::read($classe))->getCodeClasse())[2] );
                if($chiffre == $anneeSimulation) {
                    $classes[] = $classe;
                }
            }
        }
        else {
            $classes = explode(",", $classeSimulation);
        }

        $ueTC = $_GET['ueTC'];
        
        $ueSP = $_GET['ueSP'];

        foreach($classes as $classe) {

            // foreach(ClasseUE::getClasseAllUE($classe) as $ue) {
            //     foreach( ECU::getAllECU($encours) as $ecu) {
            //         if($ecu['idUE'] == $ue['idUE']) {

            //         }
            //     }
            // }

            (Classe::read($classe))->setValidationTC($ueTC);
            (Classe::read($classe))->setValidationSP($ueSP);

            $_SESSION['alert'] = 'success';
            $_SESSION['alert_message'] = 'Ajustement effectué avec succès !';

        }

        header("Location: simulations.php?anneeSimulation=".$anneeSimulation."&niveauSimulation=".$niveauSimulation."&classeSimulation=".$classeSimulation."&ueTC=".$ueTC."&ueSP=".$ueSP);

    }

    header("Location: ../View/simulations.php");

?>