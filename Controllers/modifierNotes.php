<?php

    if(isset($_GET['ecu']) && isset($_GET['classe']) && isset($_GET['typeEval']) && isset($_GET['annee'])) {

        $idClasse = $_GET['classe'];
        $idECU = $_GET['ecu'];
        $codeTypeEval = $_GET['typeEval'];
        $annee = $_GET['annee'];
        $idNiveau = $_GET['niveau'];
        $idFiliere = $_GET['filiere'];

        include_once '../Models/Evaluation.class.php';
        include_once '../Models/ClasseUE.class.php';
        include_once '../Models/TypeEval.class.php';
        include_once '../Models/ECU.class.php';
        include_once '../Models/Etudiant.class.php';
        include_once '../Models/Classe.class.php';
        include_once '../Models/Etudier.class.php';
        include_once '../Models/Niveau.class.php';
        include_once '../Models/Obtenir.class.php';

        if(isset($_POST['modifier'])) {

            $classe = Classe::read($idClasse);

            $etudes = Etudier::getAllEtudier($annee);

            foreach((Etudiant::getAllEtudiant($annee)) as $etu){

                foreach ($etudes as $etude) {

                    if($etude['idClasse'] == $idClasse) {

                        $idEtudiant = $etude['idEtudiant'];
                        //Récupération des étudiants de la classe
                        if($etu['idEtudiant'] == $idEtudiant){

                            $etudiant = Etudiant::read($idEtudiant);
                            //Récupération des leur notes
                            $evaluation = Evaluation::getTypeEvalECUEval($idECU, $codeTypeEval);
                            $obtenir = Obtenir::read($evaluation, $idEtudiant);

                            $note = $_POST[''.$idEtudiant];
                        
                            if(isset($note)) {
                                if(empty($note)) {
                                    $note = "DEF";
                                }
                                if($obtenir) {
                                    $obtenir->update($note);
                                }
                            }

                        }

                    }

                }

            }

        }
        
        header("Location:../View/modifierNotes.php?ecu=".$idECU."&typeEval=".$codeTypeEval."&classe=".$idClasse."&niveau=".$idNiveau."&filiere=".$idFiliere);

    }

?>