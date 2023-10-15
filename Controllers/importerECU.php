<?php

if(isset($_GET['import'])) {
    include_once '../Models/ECU.class.php';
    include_once '../Models/AnneeAcademique.class.php';
    include_once '../Models/UE.class.php';

    $annee_encours = (AnneeAcademique::encours())->getIdAnnee();
    $annee_precedente = $annee_encours;
    $annee_precedente[3] = $annee_encours[3]-1;
    $annee_precedente[7] = $annee_encours[7]-1;

    $ecus  = ECU::getAllECU($annee_precedente);

    foreach($ecus as $ecu) {
        
        $idUE = UE::findUEId((UE::read($ecu['idUE']))->getCodeUE());
        if($idUE) {
            $idECU = ECU::genererIdECU();
            $idUE = $idUE->getIdUE();
            ECU::create($idECU, $ecu['codeECU'], $ecu['libelleECU'], $idUE);
            
            $_SESSION['alert'] = 'success';
            $_SESSION['alert_message'] = 'Importation effectuée avec succès !'; 
        }
        else {
            $_SESSION['alert'] = 'error';
            $_SESSION['alert_message'] = 'Importation echouée : certains UE n\'existent pas encore !';
            break;
        }
    }
}

header("Location: ../View/ecu.php");

?>