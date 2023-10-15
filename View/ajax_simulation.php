<?php

if(isset($_POST['anneeSimulation']) && !empty($_POST['anneeSimulation']) && isset($_POST['niveauSimulation']) && !empty($_POST['niveauSimulation']) && isset($_POST['ueTC']) && !empty($_POST['ueTC']) && isset($_POST['ueSP']) && !empty($_POST['ueSP']) ) {


    include_once '../Models/Evaluation.class.php';
    include_once '../Models/ClasseUE.class.php';
    include_once '../Models/TypeEval.class.php';
    include_once '../Models/ECU.class.php';
    include_once '../Models/Etudiant.class.php';
    include_once '../Models/Classe.class.php';
    include_once '../Models/Etudier.class.php';
    include_once '../Models/Obtenir.class.php';
    include_once '../Models/Filiere.class.php';
    include_once '../Models/Niveau.class.php';
    include_once '../Models/UE.class.php';

    //Initialisation des valeurs
    $anneeSimulation = $_POST['anneeSimulation'];

    $niveauSimulation = $_POST['niveauSimulation'];

    $classeSimulation = "";

    if(isset($_POST['classeSimulation']) && !empty($_POST['classeSimulation'])) {
        $classeSimulation = $_POST['classeSimulation'];
        $les_classes=implode(",", $classeSimulation);
    }

    $ueTC = $_POST['ueTC'];

    $ueSP = $_POST['ueSP'];

    //Début de simulation

    if(isset($_POST['classeSimulation']) && !empty($_POST['classeSimulation'])) {

        $total = 0;
        $admissibles = 0;
        $refuses = 0;
        $avecReprises = 0;
        $sansReprises = 0;
        $defaillants = 0;

        $niveauClasses = $classeSimulation;
        foreach($niveauClasses as $niveauClasse) {
            $tot = Etudiant::getClasseNbEtu($niveauClasse);
            $total += $tot;
            $admissibles += ((Classe::read($niveauClasse))->getTauxReussite($ueTC, $ueSP) /100)*$tot;
            $refuses += (Classe::read($niveauClasse))->getRefuses($ueTC, $ueSP);

            if($anneeSimulation != (Niveau::read($niveauSimulation))->getDuree() ) {
                $sansReprises += (Classe::read($niveauClasse))->getAdmisSansReprise($ueTC, $ueSP);
                $avecReprises += (Classe::read($niveauClasse))->getAdmisAvecReprise($ueTC, $ueSP);
            }
        }
    }
    else {
        $total = 0;
        $admissibles = 0;
        $refuses = 0;
        $avecReprises = 0;
        $sansReprises = 0;
        $defaillants = 0;
        $niveauAnneeClasses = Classe::getAllClasseAnneeNiveau($anneeSimulation, $niveauSimulation);

        foreach($niveauAnneeClasses as $niveauClasse) {
            $tot = Etudiant::getClasseNbEtu($niveauClasse['idClasse']);
            $total += $tot;
            $admissibles += ((Classe::read($niveauClasse['idClasse']))->getTauxReussite($ueTC, $ueSP) /100)*$tot;
            $refuses += (Classe::read($niveauClasse['idClasse']))->getRefuses($ueTC, $ueSP);

            if($anneeSimulation != (Niveau::read($niveauSimulation))->getDuree() ) {
                $sansReprises += (Classe::read($niveauClasse['idClasse']))->getAdmisSansReprise($ueTC, $ueSP);
                $avecReprises += (Classe::read($niveauClasse['idClasse']))->getAdmisAvecReprise($ueTC, $ueSP);
            }
        }
    }

    ?>

    <div class="card elevation-3" id="showSimulation">
        <div class="card-body">
            <h5 class="text-center text-uppercase" style="text-decoration: underline;">
                <?php //echo isset($codeClasse) ? Classe::read($idClasse)->getLibClasse() : ""; ?>
            </h5>
            <table id="table_simulation" class="table table-bordered table-striped">

                <tbody>
                <?php if($anneeSimulation != (Niveau::read($niveauSimulation))->getDuree() ) { ?>
                    <tr>
                        <th scope="row">Admis Sans Reprises</th>
                        <td>
                            <div class="progress-group">
                                <?php
                                if($total != 0) {
                                    $taux = ($sansReprises/$total)*100;
                                    $taux = number_format($taux, 2);
                                }
                                else
                                    $taux = 0;
                                ?>
                                <span class="float"><?php echo "<b>".$sansReprises.'</b>/'.$total; ?></span>
                                <span class="float-right"><?php echo $taux."%"; ?></span>
                                <div class="progress progress-sm bg-dark">
                                    <div class="progress-bar <?php if($anneeSimulation == (Niveau::read($niveauSimulation))->getDuree()) { echo " bg-gradient-success"; } else { echo " bg-gradient-primary"; } ?>" style="width: <?php echo $taux ?>%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Admis Avec Reprises</th>
                        <td>
                            <?php
                            if($total != 0) {
                                $taux = ($avecReprises/$total)*100;
                                $taux = number_format($taux, 2);
                            }
                            else
                                $taux = 0;
                            ?>
                            <span class=""><?php echo "<b>".$avecReprises.'</b>/'.$total; ?></span>
                            <span class="float-right"><?php echo $taux."%"; ?></span>
                            <div class="progress progress-sm bg-dark">
                                <div class="progress-bar <?php if($anneeSimulation == (Niveau::read($niveauSimulation))->getDuree() ) { echo "bg-gradient-success"; } else { echo "bg-gradient-primary"; } ?>" style="width: <?php echo $taux ?>%"></div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th scope="row">Admissibles</th>
                    <td>
                        <?php
                        if($total != 0) {
                            $taux = ($admissibles/$total)*100;
                            $taux = number_format($taux, 2);
                        }
                        else
                            $taux = 0;
                        ?>
                        <span class=""><?php echo "<b>".$admissibles.'</b>/'.$total; ?></span>
                        <span class="float-right"><?php echo $taux."%"; ?></span>
                        <div class="progress progress-sm bg-dark">
                            <div class="progress-bar <?php if($anneeSimulation == (Niveau::read($niveauSimulation))->getDuree() ) { echo "bg-gradient-success"; } else { echo "bg-gradient-primary"; } ?>" style="width: <?php echo $taux ?>%"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Défaillants</th>
                    <td>
                        <?php
                        $defaillants = $total - ($admissibles + $refuses);
                        if($total != 0) {
                            $taux = ($defaillants/$total)*100;
                            $taux = number_format($taux, 2);
                        }
                        else
                            $taux = 0;
                        ?>
                        <span class=""><?php echo "<b>".$defaillants.'</b>/'.$total; ?></span>
                        <span class="float-right"><?php echo $taux."%"; ?></span>
                        <div class="progress progress-sm bg-dark">
                            <div class="progress-bar <?php if($anneeSimulation == (Niveau::read($niveauSimulation))->getDuree() ) { echo "bg-gradient-success"; } else { echo "bg-gradient-primary"; } ?>" style="width: <?php echo $taux ?>%"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Refusés</th>
                    <td>
                        <?php
                        if($total != 0) {
                            $taux = ($refuses/$total)*100;
                            $taux = number_format($taux, 2);
                        }
                        else
                            $taux = 0;
                        ?>
                        <span class="right"><?php echo "<b>".$refuses.'</b>/'.$total; ?></span>
                        <span class="float-right"><?php echo $taux."%"; ?></span>
                        <div class="progress progress-sm bg-dark">
                            <div class="progress-bar <?php if($anneeSimulation == (Niveau::read($niveauSimulation))->getDuree() ) { echo "bg-gradient-success"; } else { echo "bg-gradient-primary"; } ?>" style="width: <?php echo $taux ?>%"></div>
                        </div>
                    </td>
                </tr>
                </tbody>

            </table>
        </div>
        <!-- /.card-body -->
    </div>

<?php } ?>