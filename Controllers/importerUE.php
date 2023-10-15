<?php

if(isset($_GET['import'])) {
    include_once '../Models/UE.class.php';
    include_once '../Models/Classe.class.php';
    include_once '../Models/ClasseUE.class.php';
    include_once '../Models/AnneeAcademique.class.php';

    $annee_encours = (AnneeAcademique::encours())->getIdAnnee();
    $annee_precedente = $annee_encours;
    $annee_precedente[3] = $annee_encours[3]-1;
    $annee_precedente[7] = $annee_encours[7]-1;

    $ues  = UE::getAllUE($annee_precedente);
    $classeues = ClasseUE::getAllClasseUE($annee_precedente);
    $continue = true;

    foreach($classeues as $classeue) {
        
        $idclasses = explode(",", $classeue['idClasse']);
        
        foreach($idclasses as $idclasse) {
            
            $id = Classe::findClasseId( (Classe::read($idclasse))->getCodeClasse() );
            if(!$id) {
                $continue = false; 
                break;
            }
            
        }

    }

    if($continue){

        foreach($ues as $ue) {
            $idue = UE::genererIdUE();
            UE::create($idue, $ue['codeUE'], $ue['libelleUE'], $ue['coef'], $ue['codeTypeUE'], $ue['semestre'], $ue['natureUE']);
        }

        foreach($classeues as $classeue) {
            $idUE = UE::findUEId((UE::read($classeue['idUE']))->getCodeUE());
            if($idUE) {
                $idUE = $idUE->getIdUE();
                $idclasses = explode(",", $classeue['idClasse']);

                if(isset($idClasse)) {
                    unset($idClasse);
                }
                foreach($idclasses as $idclasse) {
                    
                    $id = Classe::findClasseId((Classe::read($idclasse))->getCodeClasse());
                    $idClasse[] = $id->getIdClasse();
                    
                }
                if(isset($idClasse)) {
                    $idClas = implode(",",$idClasse);
                    print $idClas;
                    ClasseUE::create($idUE, $idClas);
                
                    $_SESSION['alert'] = 'success';
                    $_SESSION['alert_message'] = 'Importation effectuée avec succès !';
                }
            }
            else {
                $_SESSION['alert'] = 'error';
                $_SESSION['alert_message'] = 'Importation echouée : certaines UE n\'existent pas encore !';
                break;
            }
        }
    }
    else {
        $_SESSION['alert'] = 'error';
        $_SESSION['alert_message'] = 'Importation echouée : certaines classes n\'existent pas encore !';
    }

}

header("Location: ../View/ue.php");

?>