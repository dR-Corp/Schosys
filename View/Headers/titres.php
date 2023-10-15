<?php
    $page = basename($_SERVER['PHP_SELF']);
    
    if(isset($add)) {
        if(isset($codeecu) && isset($evalType))
            $atext = "Ajout des notes de ".$evalType." de ".$codeecu;
    }
    else {
        if(isset($codeecu) && isset($evalType))
            $atext = "Notes de ".$evalType." de ".$codeecu;
    }

    if(isset($idecu) && isset($idue)){
        $btext = "Relevés de notes de ".(ECU::read($idecu))->getCodeECU()."(".(UE::read($idue))->getCodeUE().")";
    }

    if(isset($idClasse)){
        $ctext = "Proces verbal de ".(Classe::read($idClasse))->getCodeClasse();
        $ytext = "Proces verbal de reprise de ".(Classe::read($idClasse))->getCodeClasse();
        $ztext = "Proces verbal de fin de cycle de ".(Classe::read($idClasse))->getCodeClasse();
    }
    if(isset($classeId) && isset($codeClasse) && $page == "detailClasse.php") {
        echo '<h1 class="m-0 text-dark">Liste : '.$codeClasse.'</h1>';
    }

    if($page == "dashboard.php")
        echo '<h1 class="m-0 text-dark">Tableau de bord</h1>';
    else if($page == "annees.php")
        echo '<h1 class="m-0 text-dark">Années académiques</h1>';
    else if($page == "niveaux.php")
        echo '<h1 class="m-0 text-dark">Niveaux d\'études</h1>';
    else if($page == "filieres.php")
        echo '<h1 class="m-0 text-dark">Filières</h1>';
    else if($page == "classes.php")
        echo '<h1 class="m-0 text-dark">Années d\'étude</h1>';
    else if($page == "ue.php")
        echo '<h1 class="m-0 text-dark">UE</h1>';
    else if($page == "ecu.php")
        echo '<h1 class="m-0 text-dark">ECU</h1>';
    else if($page == "etudiants.php")
        echo '<h1 class="m-0 text-dark text-capitalize">étudiants</h1>';
    else if($page == "evaluations.php")
        echo '<h1 class="m-0 text-dark text-capitalize">évaluations</h1>';
    else if($page == "notes.php")
        echo '<h1 class="m-0 text-dark">Notes</h1>';
    else if($page == "releves_notes.php")
        echo '<h1 class="m-0 text-dark">Relevés de notes</h1>';
    else if($page == "attestations_succes.php")
        echo '<h1 class="m-0 text-dark">Attestations de succès</h1>';
    else if($page == "bulletins.php" || $page == "bulletins_listeEtu.php" || $page == "bulletins_print.php")
        echo '<h1 class="m-0 text-dark">Bulletins de notes</h1>';
    else if($page == "statuts.php")
        echo '<h1 class="m-0 text-dark">Statuts d\'étudiants</h1>';
    else if($page == "documentation.php")
        echo '<h1 class="m-0 text-dark">Statuts d\'étudiants</h1>';
    else if($page == "typeue.php")
        echo '<h1 class="m-0 text-dark">Types d\'UE</h1>';
    else if($page == "typeeval.php")
        echo '<h1 class="m-0 text-dark">Types d\'évaluations</h1>';
    else if($page == "detailNotes.php")
        echo '<h1 class="m-0 text-dark">'.$atext.'</h1>';
    else if($page == "detailReleves.php")
        echo '<h1 class="m-0 text-dark">'.$btext.'</h1>';
    else if($page == "detailProces.php")
        echo '<h1 class="m-0 text-dark">'.$ctext.'</h1>';
    else if($page == "detailPVReprise.php")
        echo '<h1 class="m-0 text-dark">'.$ytext.'</h1>';
    else if($page == "detailPVFinCycle.php")
        echo '<h1 class="m-0 text-dark">'.$ztext.'</h1>';
    else if($page == "proces_verbal.php")
        echo '<h1 class="m-0 text-dark">Procès verbaux</h1>';
    else if($page == "pv_reprises.php")
        echo '<h1 class="m-0 text-dark">Procès verbaux de reprise</h1>';
    else if($page == "pv_fincycle.php")
        echo '<h1 class="m-0 text-dark">Procès verbaux de fin de cycle</h1>';
    else if($page == "profilUsers.php")
        echo '<h1 class="m-0 text-dark">Profil Utilisateurs</h1>';
    else if($page == "utilisateur.php")
        echo '<h1 class="m-0 text-dark">Utilisateurs</h1>';
    else if($page == "modifierNotes.php")
        echo '<h1 class="m-0 text-dark">Délibération : modification de notes</h1>';
    else if($page == "simulations.php")
        echo '<h1 class="m-0 text-dark">Délibération : simulations</h1>';
    else if($page == "reprises.php")
        echo '<h1 class="m-0 text-dark">Gestion des Reprises</h1>';
    else if($page == "ajustements.php")
        echo '<h1 class="m-0 text-dark">Délibération : ajustement du procès </h1>';
    else
        echo '<h1 class="m-0 text-dark"></h1>';
?>