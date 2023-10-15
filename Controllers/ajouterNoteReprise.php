<?php

    if(isset($_GET['annee_origine']) && isset($_GET['classe_choisie']) && isset($_GET['ecu_choisie']) ){


        include_once '../Models/Evaluation.class.php';
        include_once '../Models/ClasseUE.class.php';
        include_once '../Models/TypeEval.class.php';
        include_once '../Models/ECU.class.php';
        include_once '../Models/Etudiant.class.php';
        include_once '../Models/Classe.class.php';
        include_once '../Models/Etudier.class.php';
        include_once '../Models/Obtenir.class.php';

        if(isset($_POST['ajouter'])) {

            $typeEval = "RP";
            $idecu = $_GET['ecu_choisie'];
            $annee = $_GET['annee_origine'];
            $classe = $_GET['classe_choisie'];

            $eval = Evaluation::getTypeEvalECUEval($idecu, $typeEval);

            $ecu = ECU::read($idecu);
            $ue = $ecu->getIdUE();

            //$maClasse = Classe::read($classe);

            $etudes = Etudier::getAllEtudier($annee);

            foreach ($etudes as $etude) {

                if($etude['idClasse'] == $classe) {

                    $idEtudiant = $etude['idEtudiant'];
                    
                    $note = $_POST[''.$idEtudiant];
                
                    if(isset($note) && !empty($note)) {

                        $evaluation = Evaluation::getTypeEvalECUEval($idecu, 'RP');
                        $obtenir = Obtenir::read($evaluation, $idEtudiant);
                        if($obtenir) {
                            $obtenir->update($note);
                        }
                        else {
                            Obtenir::create($eval, $idEtudiant, $note);
                        }

                    }

                }

            }

        }
        
        header("Location:../View/reprises.php?annee_origine=".$annee."&classe_choisie=".$classe."&ecu_choisie=".$idecu);
    }

?>