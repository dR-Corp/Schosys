<?php

    if(isset($_GET['idEvaluation']) && isset($_GET['idecu']) && isset($_GET['annee'])){

        include_once '../Models/Evaluation.class.php';
        include_once '../Models/ClasseUE.class.php';
        include_once '../Models/TypeEval.class.php';
        include_once '../Models/ECU.class.php';
        include_once '../Models/Etudiant.class.php';
        include_once '../Models/Classe.class.php';
        include_once '../Models/Etudier.class.php';
        include_once '../Models/Obtenir.class.php';

        if(isset($_POST['creer'])) {

            $eval = $_GET['idEvaluation'];
            $idecu = $_GET['idecu'];
            $annee = $_GET['annee'];

            $ecu = ECU::read($idecu);
            $ue = $ecu->getIdUE();
            
            $classe_ue = ClasseUE::read($ue);
            $classeIds = explode(",",$classe_ue->getidClasse());
            foreach ($classeIds as $classeId) {
                //if($classe_ue['codeUE'] == $ue) {

                    $classe = Classe::read($classeId);

                    $etudes = Etudier::getAllEtudier($annee);

                    foreach ($etudes as $etude) {

                        if($etude['idClasse'] == $classeId) {

                            $idEtudiant = $etude['idEtudiant'];
                            //Récupération des étudiants de la classe
                            //$etudiant = Etudiant::read($matricule);
                            //Récupération des leurs notes

                            //$obtenir = Obtenir::read($eval, $matricule);
                            $note = $_POST[''.$idEtudiant];
                        
                            if(isset($note)) {
                                if(empty($note)) {
                                    $note = "DEF";
                                }
                                Obtenir::create($eval, $idEtudiant, $note);
                            }

                        }

                    }

                //}

            }            

        }
        
        header("Location:../View/detailNotes.php?idECU=".$idecu."&idEvaluation=".$eval);
    }

?>