<?php
    session_start();
    if(isset($_SESSION['username']) && $_SESSION["codeProfil"] != "DA"  && $_SESSION["codeProfil"] != "COM") {
        Header("Location: tableau-de-bord");
    }
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }
    
    if(isset($_GET['idClasse'])) {
        $idClasse = $_GET['idClasse'];
    }
    if(isset($_GET['annee_origine'])) {
        $annee_origine = $_GET['annee_origine'];
    }
?>
<?php include("Headers/noyear.php") ?>
<!DOCTYPE html>
<html>
<head>
  <?php include("Headers/head.php") ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Navbar -->
    <?php include("Headers/navbar.php") ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("Headers/sidebar.php") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-9">
                    <?php
                    
                        include_once '../Models/Evaluation.class.php';
                        include_once '../Models/AnneeAcademique.class.php';
                        include_once '../Models/ClasseUE.class.php';
                        include_once '../Models/TypeEval.class.php';
                        include_once '../Models/UE.class.php';
                        include_once '../Models/ECU.class.php';
                        include_once '../Models/Etudiant.class.php';
                        include_once '../Models/Classe.class.php';
                        include_once '../Models/Etudier.class.php';
                        include_once '../Models/Obtenir.class.php';
                        include_once '../Models/Filiere.class.php';
                        include_once '../Models/Statut.class.php';
                        include("Headers/titres.php");
                    ?>
                </div>
                <div class="col-sm-3">
                    <a href="../proces-verbaux-de-reprises/<?= $annee_origine ?>"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des notes"><i class="fas fa-angle-double-left" aria-hidden="true"></i> Procès verbaux</button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    
    <?php
        $annee = AnneeAcademique::read($annee_origine);
        $ues = UE::getClasseAllUE($idClasse);
        $ecus = ECU::getAllECU($annee->getIdAnnee());
        $obtenirs = Obtenir::getallobtenir($annee->getIdAnnee());
        $evaluations = Evaluation::getAllEvaluation($annee->getIdAnnee());
        $typeEval = TypeEval::getAllTypeEval();
    ?>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- <h4 class="text-center w-full py-2 text-white font-weight-bold" style="background-color: #044687;">
                        Procès verbal de reprise
                    </h4> -->
                    <div class="card table-responsive">
                        <div class="card-body">
                            <style>
                                td {
                                    white-space: nowrap;
                                }
                            </style>
                            <div class="row text-sm">
                                <div class="col-sm-6 text-center" style="width: 50%;">
                                    <p>
                                        République du Bénin<br>******<br>Ministère de l'Enseignement Supérieure et de la Recherche Scientifique<br>*****<br>Université de Parakou<br>******<br>Institut Universitaire de Technologie (IUT)<br>
                                    </p>
                                </div>
                                <div class="col-sm-2 text-center" style="width: 20%;"></div>
                                <div class="col-sm-4" style="width: 30%;">
                                    <p>Année Academique<?php print " ". $annee->getAnnee(); ?></p>
                                    <p>Procès Verbal des Résultats de délibérations</p>
                                    <p>Après reprises</p>
                                </div>
                            </div>
                            <table id="table_proces" class="table table-sm table-bordered table-striped text-xs display" style="width:100%">
                                <thead>
                                    <tr>
                                        <!-- Il faudra gérer le semestre ici -->
                                        <th scope="col" colspan="10000">Filière : <?php echo Filiere::read((Classe::read($idClasse))->getIdFiliere())->getLibFiliere(); ?>(S_)</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">N° Ordre</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Matricule</th>
                                        <th scope="col" rowspan="4" class="name" style="vertical-align:middle;text-align:center;">Nom Prénoms</th>
                                        <?php
                                            $scoef = 0;
                                            $idUE = 1;
                                            foreach($ues as $ue):
                                                $nbr = ECU::getUEECUNumber($ue['idUE']);
                                        ?>
                                            <th scope="col" colspan="<?php echo $nbr>1 ? 3*$nbr+2 : 3*$nbr+1 ?>" style="vertical-align:middle;text-align:center;">
                                                UE<?php echo "$idUE : ". $ue['libelleUE'] ?>
                                            </th>
                                        <?php 
                                            $idUE++;
                                            endforeach
                                        ?>
                                        <th scope="col" rowspan="3" style="vertical-align:middle;text-align:center;">Total crédits validé</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Pourcentage d'U.E.s validées</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Moyenne sur 20</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">Décision du Jury basée sur les Crédits Validés</th>
                                        <th scope="col" rowspan="4" style="vertical-align:middle;text-align:center;">N° Ordre</th>
                                    </tr>
                                    <tr>
                                    <?php
                                        foreach($ues as $ue):
                                            $nbr = ECU::getUEECUNumber($ue['idUE']);
                                    ?>
                                            <th scope="col" colspan="<?php echo $nbr>1 ? 3*$nbr+1 : 3*$nbr ?>" style="vertical-align:middle;text-align:center;">
                                                CREDITS
                                            </th>
                                            <th style="vertical-align:middle;text-align:center;">
                                                <?php echo $ue['coef']; $scoef = $scoef + $ue['coef']; ?>
                                            </th>
                                        <?php endforeach ?>
                                        
                                    </tr>
                                    <tr>
                                        <?php
                                            $idUE = 1;
                                            foreach($ues as $ue):
                                        ?>
                                        <?php
                                            $ecus = ECU::getUEECU($ue['idUE']);
                                            foreach($ecus as $ecu):
                                                $nbr = ECU::getUEECUNumber($ue['idUE']);
                                        ?>
                                            <th scope="col" colspan="2" style="vertical-align:middle;text-align:center;">
                                                <?php echo $ecu['libelleECU'] ?>
                                            </th>
                                            <?php if($nbr > 1): ?>
                                                <th scope="col" rowspan="2" style="vertical-align:middle;text-align:center;">
                                                    Moyenne de l'ECU
                                                </th>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                            <th scope="col" rowspan="2" style="vertical-align:middle;text-align:center;">
                                                Moyenne de l'UE<?php echo $idUE ?>
                                            </th>
                                            <th scope="col" rowspan="2" style="vertical-align:middle;text-align:center;">
                                                Décision (validée ou non) relative à l'UE<?php echo $idUE ?>
                                            </th>
                                        <?php 
                                            $idUE++;
                                            endforeach
                                        ?>
                                    </tr>
                                    <tr>
                                        <?php foreach($ues as $ue): ?>
                                        <?php
                                            $ecus = ECU::getUEECU($ue['idUE']);
                                            foreach($ecus as $ecu):
                                        ?>
                                            <th style="vertical-align:middle;text-align:center;">CC</th>
                                            <th style="vertical-align:middle;text-align:center;">EF</th>
                                        <?php endforeach ?>
                                        <?php endforeach ?>
                                        
                                        <th scope="col"><?php echo $scoef ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    include_once '../Models/Classe.class.php';
                                    include_once '../Models/Filiere.class.php';
                                    include_once '../Models/Niveau.class.php';
                                    $etudiants = Etudiant::getAllEtudiant($annee->getIdAnnee());
                                    $id = 1;
                                    foreach($etudiants as $etudiant) {
                                        if($etudiant['idClasse']  == $idClasse ){
                                            $defaillant = false;
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $id ?></th>
                                        <td><?php echo $etudiant['matricule'] ?></td>
                                        <td style="width: 400px;"><?php echo $etudiant['nom']." ".$etudiant['prenom'] ?></td>

                                        <?php
                                        $coefV = 0;
                                        $moyenne = 0.0;
                                            foreach($ues as $ue):
                                        ?>
                                        <?php
                                            $ecus = ECU::getUEECU($ue['idUE']);
                                            $nbr = ECU::getUEECUNumber($ue['idUE']);
                                            $smecu = 0;
                                            $mecu = 0;
                                            $secu = 0;
                                            
                                            $laClasse = Classe::read($idClasse);
                                            $lUE = UE::read($ue['idUE']);
                                            $moyUE = $lUE->getMoyUE($etudiant['idEtudiant']);
                                            unset($efa);

                                            if($lUE->getCodeTypeUE() == "TC") {
                                                $validation = $laClasse->getValidationTC();
                                            }
                                            else {
                                                $validation = $laClasse->getValidationSP();
                                            }

                                            if($validation != 12 && $moyUE < 12 && $moyUE >= $validation) {
                                                
                                                $efa = $lUE->ajusterUE($idClasse, $etudiant['idEtudiant']);
                                                
                                            }

                                            $numECU = 0;
                                            foreach($ecus as $ecu):
                                        ?>
                                            <td style="vertical-align:middle;text-align:center;">
                                                <?php
                                                    $rpcc = Evaluation::getEvalNote("RP", $ecu['idECU'], $etudiant['idEtudiant']);
                                                    if(isset($rpcc) && !empty($rpcc)) {
                                                        echo $cc = $rpcc;
                                                    }
                                                    else {
                                                        echo $cc = Evaluation::getEvalNote("CC", $ecu['idECU'], $etudiant['idEtudiant']);
                                                        if(empty($cc)) {
                                                            if(isset($efa)) {
                                                                echo $cc = number_format(($efa[$numECU]), 2);
                                                            }
                                                            else {
                                                                echo $cc = Evaluation::getEvalNote("EF", $ecu['idECU'], $etudiant['idEtudiant']);
                                                            }
                                                        }
                                                    }
                                                    if($nbr == 1):
                                                        if($cc == "DEF") {//S'il y a un seul défaillant
                                                            $secu = -1;
                                                            $defaillant = true;
                                                        }
                                                        else {
                                                            $secu=number_format(($secu+$cc*0.4), 2);
                                                        }
                                                    endif
                                                ?>
                                            </td>
                                            <td style="vertical-align:middle;text-align:center;">
                                                <?php
                                                    $rpef = Evaluation::getEvalNote("RP", $ecu['idECU'], $etudiant['idEtudiant']);
                                                    if(isset($rpef) && !empty($rpef)) {
                                                        echo $ef = $rpcc;
                                                    }
                                                    else {
                                                        if(isset($efa)) {
                                                            echo $ef = number_format(($efa[$numECU]), 2);
                                                        }
                                                        else {
                                                            echo $ef = Evaluation::getEvalNote("EF", $ecu['idECU'], $etudiant['idEtudiant']);
                                                        }
                                                    }
                                                    
                                                    if($nbr == 1):
                                                        if($ef == "DEF" || $secu == -1) {//S'il y a un seul défaillant
                                                            $secu = -1;
                                                            $defaillant = true;
                                                        }
                                                        else {
                                                            $secu=number_format(($secu+$ef*0.6), 2);
                                                        }
                                                    endif
                                                ?>
                                            </td>
                                            <?php if($nbr > 1): ?>
                                                <td style="vertical-align:middle;text-align:center;">
                                                    <?php

                                                        if($ef == "DEF" || $cc == "DEF") {//S'il y a un seul défaillant
                                                            $mecu = -1;
                                                            echo "DEF";
                                                            $smecu = -1;
                                                        }
                                                        else {
                                                            
                                                                echo $mecu = number_format(($cc*0.4+$ef*0.6), 2);
                                                            
                                                            if($smecu != -1) {
                                                                $smecu = $smecu + $mecu;
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                            <?php endif ?>
                                        <?php
                                            $numECU++;
                                            endforeach 
                                        ?>
                                            <td style="vertical-align:middle;text-align:center;">
                                            <?php if($nbr > 1): ?>
                                                <?php
                                                    
                                                    if($smecu == -1) {
                                                        $mue = -1;
                                                        echo "DEF";
                                                    }
                                                    else {
                                                        echo $mue = number_format(($smecu/$nbr), 2);
                                                    }

                                                    if($defaillant) {
                                                        $moyenne = "DEF";
                                                    }
                                                    else {
                                                        $moyenne = $moyenne + $mue*$ue['coef'];
                                                    }
                                                ?>
                                            <?php else: ?>
                                                <?php
                                                    if($secu == -1) {
                                                        $mecu = $secu;
                                                        echo "DEF";
                                                    }
                                                    else{
                                                        
                                                            echo $mecu = $secu;
                                                        
                                                    }

                                                    if($defaillant) {
                                                        $moyenne = "DEF";
                                                    }
                                                    else {
                                                        $moyenne = $moyenne + $mecu*$ue['coef'];
                                                    }
                                                ?>
                                            <?php endif ?>
                                            </td>
                                            <td style="vertical-align:middle;text-align:center;">
                                            <?php if($nbr > 1){ ?>
                                                <?php
                                                    if($mue >= 12): echo "V";
                                                        $coefV = $coefV + $ue['coef'];
                                                    elseif($mue == -1):
                                                        echo "DEF";
                                                    else:
                                                        echo "NV";
                                                    endif ?>
                                            <?php }else{ ?>
                                                <?php
                                                    if($mecu >= 12): echo "V";
                                                        $coefV = $coefV + $ue['coef'];
                                                    elseif($mecu == -1):
                                                        echo "DEF";
                                                    else:
                                                        echo "NV";
                                                    endif
                                                ?>
                                            <?php } ?>
                                            </td>
                                        <?php endforeach ?>
                                        
                                        <td><?php echo $coefV ?></td>
                                        <td><?php echo $pourcent = round((($coefV/$scoef)*100)) ; echo ' %'; ?></td>
                                        <td><?php if($defaillant) { echo "DEF"; } else {echo $moyenne = number_format(($moyenne/$scoef), 2);} ?></td>
                                        <td>
                                            <?php
                                                $class = explode("-", (Classe::read($idClasse))->getCodeClasse());
                                                $duree = Niveau::read((Classe::read($idClasse))->getIdNiveau())->getDuree();

                                                if($defaillant) {
                                                    echo "DEF";
                                                }
                                                else {
                                                    if($class[2] == $duree) {
                                                        if($pourcent == 100): echo "ADMISSIBLE"; else: echo "REFUSE(E)"; endif;
                                                    }
                                                    else {
                                                        if($pourcent >= 85): echo "ADMISSIBLE"; else: echo "REFUSE(E)"; endif;
                                                    }
                                                }

                                            ?>
                                        </td>
                                        <td><?php echo $id ?></td>
                                    </tr>
                                <?php
                                    $id++;
                                        }
                                    } 
                                ?>
                                </tbody>
                                                        
                            </table>
                        </div>
                        
                        <!-- /.card-body -->
                        </div>
                        <div class="container-fluid">
                            <div class="row mb-4">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPrint()" id="<?php echo 'print-'.$evaluation['idEvaluation']; ?>"><i class="fas fa-print" aria-hidden="true"></i> Imprimer</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPDF('<?php echo (Classe::read($idClasse))->getCodeClasse(); ?>')" id="<?php echo 'download-'.$evaluation['idEvaluation']; ?>"><i class="fas fa-file-pdf" aria-hidden="true"></i> PDF</button>
                                </div>
                            </div>
                        </div>
                        <script>
                            function toPDF(ind){
                                const invoice = this.document.getElementById("table_proces");
                                var opt = {
                                    margin:       0.3,
                                    filename:     'proces verbal '+ind+'.pdf',
                                    image:        { type: 'jpeg', quality: 0.98 },
                                    html2canvas:  { scale: 2 },
                                    jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape', fontName: 'Times new roman'}
                                    
                                };
                                html2pdf().from(invoice).set(opt).save();
                            };

                            function toPrint() {
                                $('#table_proces').printThis({
                                    debug: false,               // show the iframe for debugging
                                    importCSS: true,          // import parent page css
                                    importStyle: false,         // import style tags
                                    printContainer: true,       // print outer container/$.selector
                                    loadCSS: "http://127.0.0.1/Schosys2/Ressources/Dashboard/dist/css/adminlte.min.css",           // path to additional css file - use an array [] for multiple
                                    pageTitle: "",              // add title to print page
                                    removeInline: false,        // remove inline styles from print elements
                                    removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
                                    printDelay: 333,            // variable print delay
                                    header: null,               // prefix to html
                                    footer: null,               // postfix to html
                                    base: false,                // preserve the BASE tag or accept a string for the URL
                                    formValues: true,           // preserve input/form values
                                    canvas: false,              // copy canvas content
                                    doctypeString: '<!DOCTYPE html>', // enter a different doctype for older markup
                                    removeScripts: false,       // remove script tags from print content
                                    copyTagClasses: false,      // copy classes from the html & body tag
                                    beforePrintEvent: null,     // callback function for printEvent in iframe
                                    beforePrint: null,          // function called before iframe is filled
                                    afterPrint: null            // function called before iframe is removed
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include("Footers/footer.php") ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

    <?php include("Footers/script.php") ?>

    <script>

    $(function () {
        $('[data-tog="tooltip"]').tooltip()
    });

    </script>

</body>
</html>
