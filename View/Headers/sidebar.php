<aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link" style="background-color: #044687;">
        <img src="../Ressources/Dashboard/dist/img/iut.png" alt="Logo iut" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-bold text-white">SCHOSYS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: #19233e;">

    <?php
    
    $open = basename($_SERVER['PHP_SELF']);

        if(isset($_SESSION['username'])) {
            if ($_SESSION["codeProfil"] == "AD") {
                ?>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item mt-1 <?php if($open == "dashboard.php") echo'menu-open' ?>">
                        <a href="../tableau-de-bord" class="nav-link font-weight-bold <?php if($open == "dashboard.php") echo'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "utilisateur.php") echo'menu-open' ?>">
                        <a href="../utilisateurs" class="nav-link font-weight-bold <?php if($open == "utilisateur.php") echo'active' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Utilisateurs</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "utilisateur.php") echo'menu-open' ?>">
                        <a href="../profils-utilisateur" class="nav-link font-weight-bold <?php if($open == "profilUsers.php") echo'active' ?>">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>Profil Utilisateurs</p>
                        </a>
                    </li>
                </nav>

                <?php
            }
            else if ($_SESSION["codeProfil"] == "DA") {
                ?>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item <?php if($open == "dashboard.php") echo'menu-open' ?>">
                        <a href="../tableau-de-bord" class="nav-link font-weight-bold <?php if($open == "dashboard.php") echo'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                        </a>
                    </li>
                    <li class="nav-item <?php if($open == "annees.php") echo'menu-open' ?>">
                        <a href="../annees-academiques" class="nav-link font-weight-bold <?php if($open == "annees.php") echo'active' ?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Années Academiques</p>
                        </a>
                    </li>
                    <li class="nav-item <?php if($open == "niveaux.php") echo'menu-open' ?>">
                        <a href="../niveaux" class="nav-link font-weight-bold <?php if($open == "niveaux.php") echo'active' ?>">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>Niveaux</p>
                        </a>
                    </li>
                    <li class="nav-item <?php if($open == "filieres.php") echo'menu-open' ?>">
                        <a href="../filieres" class="nav-link font-weight-bold <?php if($open == "filieres.php") echo'active' ?>">
                        <i class="nav-icon fas fa-code-branch"></i>
                        <p>Filières</p>
                        </a>    
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "classes.php" || $open == "detailClasse.php") echo'menu-open' ?>">
                        <a href="../annees-etude" class="nav-link font-weight-bold <?php if($open == "classes.php" || $open == "detailClasse.php") echo'active' ?>">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Années d'étude</p>
                        </a>
                    </li>
                    <li class="nav-item <?php if($open == "ue.php" || $open == "typeue.php") echo'menu-open' ?>">
                        <a href="../ue" class="nav-link font-weight-bold <?php if($open == "ue.php" || $open == "typeue.php") echo'active' ?>">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>UE</p>
                        </a>
                    </li>           
                    <li class="nav-item <?php if($open == "ecu.php") echo'menu-open' ?>">
                        <a href="../ecu" class="nav-link font-weight-bold <?php if($open == "ecu.php") echo'active' ?>">
                        <i class="nav-icon fas fa-table"></i>
                        <p>ECU</p>
                        </a>    
                    </li>
                    <li class="nav-item <?php if($open == "etudiants.php") echo'menu-open' ?>">
                        <a href="../etudiants" class="nav-link font-weight-bold <?php if($open == "etudiants.php") echo'active' ?>">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Etudiants</p>
                        </a>
                    </li>
                    <li class="nav-item <?php if($open == "evaluations.php" || $open == "typeeval.php") echo'menu-open' ?>">
                        <a href="../evaluations" class="nav-link font-weight-bold <?php if($open == "evaluations.php" || $open == "typeeval.php") echo'active' ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Evaluations</p>
                        </a>
                    </li>
                    <li class="nav-item <?php if($open == "notes.php" || $open == "detailNotes.php") echo'menu-open' ?>">
                        <a href="../notes-liste-evaluations" class="nav-link font-weight-bold <?php if($open == "notes.php" || $open == "detailNotes.php") echo'active' ?>">
                        <i class="nav-icon fas fa-marker"></i>
                        <p>Notes</p>
                        </a>
                    </li>
                    <li class="nav-item <?php if($open == "releves_notes.php" || $open == "detailReleves.php") echo'menu-open' ?>">
                        <a href="../releves-de-notes-liste-ecu" class="nav-link font-weight-bold <?php if($open == "releves_notes.php" || $open == "detailReleves.php") echo'active' ?>">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Relevés de notes</p>
                        </a>

                    </li>
                    <li class="nav-item has-treeview <?php if($open == "proces_verbal.php" || $open == "pv_reprises.php" || $open == "pv_fincycle.php" || $open == "detailPVFinCycle.php" || $open == "detailPVReprise.php" || $open == "detailProces.php") echo 'menu-open' ?>">
                        <a href="../#" class="nav-link font-weight-bold">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Procès verbaux</p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../proces-verbaux" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "proces_verbal.php" || $open == "detailProces.php") echo 'text-blue' ?>"></i>
                                <p> PV</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../proces-verbaux-de-reprises" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "pv_reprises.php" || $open == "detailPVReprise.php") echo 'text-blue' ?>"></i>
                                <p> PV de reprises</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../proces-verbaux-de-fin-de-cycle" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "pv_fincycle.php" || $open == "detailPVFinCycle.php") echo 'text-blue' ?>"></i>
                                <p> PV de fin de cycle</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "reprises.php") echo'menu-open' ?>">
                        <a href="../reprises" class="nav-link font-weight-bold <?php if($open == "reprises.php") echo'active' ?>">
                        <i class="nav-icon fas fa-redo-alt"></i>
                        <p>Reprises</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview <?php if($open == "modifierNotes.php" || $open == "simulations.php" || $open == "ajustements.php") echo 'menu-open' ?>">
                        <a href="../#" class="nav-link font-weight-bold">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Délibération</p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../modification-de-notes" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "modifierNotes.php") echo 'text-blue' ?>"></i>
                                <p> Notes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../simulations" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "simulations.php") echo 'text-blue' ?>"></i>
                                <p> Simulations</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </nav>

                <?php
            }
            else if ($_SESSION["codeProfil"] == "CS") {
                ?>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item mt-1 <?php if($open == "dashboard.php") echo'menu-open' ?>">
                        <a href="../tableau-de-bord" class="nav-link font-weight-bold <?php if($open == "dashboard.php") echo'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1  <?php if($open == "annees.php") echo'menu-open' ?>">
                        <a href="../annees-academiques" class="nav-link font-weight-bold <?php if($open == "annees.php") echo'active' ?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Années Academiques</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "etudiants.php") echo'menu-open' ?>">
                        <a href="../etudiants" class="nav-link font-weight-bold <?php if($open == "etudiants.php") echo'active' ?>">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Etudiants</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "statuts.php") echo'menu-open' ?>">
                        <a href="../statuts-etudiants" class="nav-link font-weight-bold <?php if($open == "statuts.php") echo'active' ?>">
                        <i class="nav-icon fas fa-flask"></i>
                        <p>Statuts</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "bulletins.php" || $open == "bulletins_listeEtu.php" || $open == "bulletins_print.php") echo'menu-open' ?>">
                        <a href="../bulletins-liste-classes" class="nav-link font-weight-bold <?php if($open == "bulletins.php" || $open == "bulletins_listeEtu.php" || $open == "bulletins_print.php") echo'active' ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Bulletins de notes</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "attestations_succes.php" || $open == "printAttestaion.php"  || $open == "detailAttestaion.php") echo'menu-open' ?>">
                        <a href="../attestations-liste-classe" class="nav-link font-weight-bold <?php if($open == "attestations_succes.php" || $open == "printAttestaion.php"  || $open == "detailAttestaion.php") echo'active' ?>">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Attestations de succès</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item mt-1 <?php //if($open == "documentation.php") echo'menu-open' ?>">
                        <a href="documentation.php" class="nav-link font-weight-bold <?php //if($open == "documentations.php") echo'active' ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Documentation</p>
                        </a>
                    </li> -->
                </nav>

                <?php
            }
            else if ($_SESSION["codeProfil"] == "SC") {
                ?>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item mt-1 <?php if($open == "dashboard.php") echo'menu-open' ?>">
                        <a href="../tableau-de-bord" class="nav-link font-weight-bold <?php if($open == "dashboard.php") echo'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "annees.php") echo'menu-open' ?>">
                        <a href="../annees-academiques" class="nav-link font-weight-bold <?php if($open == "annees.php") echo'active' ?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Années Academiques</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "notes.php" || $open == "detailNotes.php") echo'menu-open' ?>">
                        <a href="../notes-liste-evaluations" class="nav-link font-weight-bold <?php if($open == "notes.php" || $open == "detailNotes.php") echo'active' ?>">
                        <i class="nav-icon fas fa-marker"></i>
                        <p>Notes</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "etudiants.php") echo'menu-open' ?>">
                        <a href="../etudiants" class="nav-link font-weight-bold <?php if($open == "etudiants.php") echo'active' ?>">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Etudiants</p>
                        </a>
                    <!-- </li>
                    <li class="nav-item mt-1 <?php //if($open == "documentation.php") echo'menu-open' ?>">
                        <a href="documentation.php" class="nav-link font-weight-bold <?php //if($open == "documentations.php") echo'active' ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Documentation</p>
                        </a>
                    </li> -->
                </nav>

                <?php
            }
            else if ($_SESSION["codeProfil"] == "COM") {
                ?>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item mt-1 <?php if($open == "dashboard.php") echo'menu-open' ?>">
                        <a href="../tableau-de-bord" class="nav-link font-weight-bold <?php if($open == "dashboard.php") echo'active' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                        </a>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "annees.php") echo'menu-open' ?>">
                        <a href="../annees-academiques" class="nav-link font-weight-bold <?php if($open == "annees.php") echo'active' ?>">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Années Academiques</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview <?php if($open == "proces_verbal.php" || $open == "pv_reprises.php" || $open == "pv_fincycle.php" || $open == "detailPVFinCycle.php" || $open == "detailPVReprise.php" || $open == "detailProces.php") echo 'menu-open' ?>">
                        <a href="../#" class="nav-link font-weight-bold">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Procès verbaux</p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../proces-verbaux" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "proces_verbal.php" || $open == "detailProces.php") echo 'text-blue' ?>"></i>
                                <p> PV</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../proces-verbaux-de-reprises" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "pv_reprises.php" || $open == "detailPVReprise.php") echo 'text-blue' ?>"></i>
                                <p> PV de reprises</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../proces-verbaux-de-fin-de-cycle" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "pv_fincycle.php" || $open == "detailPVFinCycle.php") echo 'text-blue' ?>"></i>
                                <p> PV de fin de cycle</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item mt-1 <?php if($open == "reprises.php") echo'menu-open' ?>">
                        <a href="../reprises" class="nav-link font-weight-bold <?php if($open == "reprises.php") echo'active' ?>">
                        <i class="nav-icon fas fa-redo-alt"></i>
                        <p>Reprises</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview <?php if($open == "modifierNotes.php" || $open == "simulations.php" || $open == "ajustements.php") echo 'menu-open' ?>">
                        <a href="../#" class="nav-link font-weight-bold">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Délibération</p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../modification-de-notes" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "modifierNotes.php") echo 'text-blue' ?>"></i>
                                <p> Notes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../simulations" class="nav-link font-weight-bold">
                                <i class="nav-icon fas fa-angle-right ml-4 <?php if($open == "simulations.php") echo 'text-blue' ?>"></i>
                                <p> Simulations</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </nav>

                <?php
            }
            else {
            }
        }
    ?>

    </div>
  </aside>