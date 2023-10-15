<?php

    if(isset($_POST['modifier'])){

        include_once '../Models/Evaluation.class.php';
        include_once '../Models/ClasseUE.class.php';
        include_once '../Models/TypeEval.class.php';
        include_once '../Models/ECU.class.php';
        include_once '../Models/Etudiant.class.php';
        include_once '../Models/Classe.class.php';
        include_once '../Models/Etudier.class.php';
        include_once '../Models/Obtenir.class.php';

        if(isset($_GET['idEvaluation']) && isset($_GET['idecu']) && isset($_GET['idEtudiant'])) {

            $eval = $_GET['idEvaluation'];
            $idecu = $_GET['idecu'];
            $idEtudiant = $_GET['idEtudiant'];

            $ecu = ECU::read($idecu);
            $ue = $ecu->getIdUE();

            $obtenir = Obtenir::read($eval, $idEtudiant);

            $note = $_POST['note'];
                        
            if(isset($note)) {
                if(empty($note)) {
                    $note = "DEF";
                }
                if($obtenir) {
                    $obtenir->update($note);
                }
                else {
                    Obtenir::create($eval, $idEtudiant, $note);
                }
            }

            header("Location:../View/detailNotes.php?idECU=".$idecu."&idEvaluation=".$eval);

        }

    }

?>