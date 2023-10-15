<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion.php");
    }
    if(isset($_GET['idEtudiant'])) {
        $idEtu = $_GET['idEtudiant'];
    }
    if(isset($_GET['idClasse'])) {
        $idClas = $_GET['idClasse'];
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
                <div class="col-sm-12">
                    <?php include("Headers/titres.php") ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card table-responsive" id="bulletin">
                        <div class="card-body" style="margin-top: 120px;">
                            <div class="row">
                                <div class="col-sm-6">
                                <p class="font-weight-bold">N° ________ -<?php echo date('Y'); ?>/IUT-UP/DA/SSS/SGE/CDS</p>
                                </div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                <p class="font-weight-bold">
                                    Parakou, le 
                                    <?php
                                        
                                        include_once '../Models/Etudiant.class.php';
                                        include_once '../Models/Filiere.class.php';
                                        include_once '../Models/Classe.class.php';
                                        $laClasse = Classe::read($idClas);
                                        $etuObject = Etudiant::read($idEtu);
                                        $dec = explode("-", $laClasse->getCodeClasse());

                                        $date = date('Y-m-d');
                                        setlocale(LC_TIME, "fr_FR.utf8", 'fra');
                                        echo ' '.date("d").' <span class="text-capitalize">'.strftime("%B", strtotime($date)).'</span> '.date("Y");
                                    ?>
                                </p>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6" style="border: 2px solid black; padding: 5px;">
                                    ATTESTATION DE VALIDATION DES UE<br>
                                    <span class="font-weight-bold">Année Académique <?php echo $annee->getAnnee(); ?></span>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    Le Directeur de l'Institut Universitaire de Technologie, soussigné, atteste que l'étudiant<?php echo ($etuObject->getSexeEtu()=="M") ? "" : "e"; ?>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p style="font-weight: bold;">
                                        <span style="text-decoration: underline;">Nom</span> : <?php echo $etuObject->getNomEtu(); ?><br>
                                        <span style="text-decoration: underline;">Prénoms</span> : <?php echo $etuObject->getPrenomEtu() ?><br>
                                        <span style="text-decoration: underline;">Date de naissance</span> : <?php $date = new DateTime($etuObject->getDateNaissanceEtu()); echo str_replace("-", "/", $date->format('d-m-Y')); ?><br>
                                    </p>
                                </div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <p style="font-weight: bold;">
                                        <span style="text-decoration: underline;">Lieu de naissance</span> : <?php echo $etuObject->getLieuNaissanceEtu() ?><br>
                                        <span style="text-decoration: underline;">Numéro d'inscription</span> : <?php echo $etuObject->getMatriculeEtu() ?><br>
                                        <span style="text-decoration: underline;">Filière</span> : <?php echo (Filiere::read(Filiere::findFiliereId($dec[1])->getIdFiliere()))->getLibFiliere(); ?><br>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="text-center">
                                        inscrit<?php echo ($etuObject->getSexeEtu()=="M") ? " " : "e "; ?> en 
                                        <?php
                                            if($dec[0] == "LP") {
                                                if($dec[2] == 1) {
                                                    echo "première année de Licence (L1) ";
                                                }
                                                else if($dec[2] == 2) {
                                                    echo "deuxième année de Licence (L2) ";
                                                }
                                                else if($dec[2] == 3) {
                                                    echo "troisième année de Licence (L3) ";
                                                }
                                            }
                                            else if($dec[0] == "MP") {
                                                if($dec[2] == 1) {
                                                    echo "première année de Master (M1) ";
                                                }
                                                else if($dec[2] == 2) {
                                                    echo "deuxième année de Master (M2) ";
                                                }
                                            }
                                        ?>
                                        a validé les Unités d'Enseignements (UE) ci-dessous :
                                    </p>
                                </div>
                            </div>

                            <style>
                                td {
                                    white-space: nowrap;
                                    border: 1px solid black;
                                }
                                table {
                                    border: 1px solid black;
                                }
                            </style>
                            <table id="table_classes" class="table table-bordered table-sm border-dark">
                            <thead>
                                <tr>
                                    <th scope="col" style="vertical-align:middle;text-align:center;">UE</th>
                                    <th scope="col" style="vertical-align:middle;text-align:center;">ECU</th>
                                    <th scope="col" style="vertical-align:middle;text-align:center;">Note/20</th>
                                    <th scope="col" style="vertical-align:middle;text-align:center;">Crédits</th>
                                    <th scope="col" style="vertical-align:middle;text-align:center;">Résultat</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include_once '../Models/Niveau.class.php';
                                include_once '../Models/UE.class.php';
                                include_once '../Models/ECU.class.php';
                                include_once '../Models/Semestre.class.php';

                                $sems = Semestre::getAllSemestre($annee->getIdAnnee());
                                $ues = UE::getClasseAllUE($idClas);
                                $totalCredits = 0;
                                $creditsObtenus = 0;
                                $moyenne = 0.0;
                        
                                foreach($sems as $sem):
                                ?>
                                    <tr>
                                        <td colspan="5" class="bg-dark text-center" style="background-color: black; color: white;">SEMESTRE
                                            <?php
                                                $dec = explode("-", $laClasse->getCodeClasse());
                                                if($dec[0] == "LP") {
                                                    if($dec[2] == 1) {
                                                        if($sem['codeSemestre'] == 1) {
                                                            echo "I";
                                                        }
                                                        else {
                                                            echo "II";
                                                        }
                                                    }
                                                    else if($dec[2] == 2) {
                                                        if($sem['codeSemestre'] == 1) {
                                                            echo "III";
                                                        }
                                                        else  if($dec[2] == 3) {
                                                            echo "IV";
                                                        }
                                                    }
                                                    else {
                                                        if($sem['codeSemestre'] == 1) {
                                                            echo "V";
                                                        }
                                                        else {
                                                            echo "VI";
                                                        }
                                                    }
                                                }
                                                else if($dec[0] == "MP") {
                                                    if($dec[2] == 1) {
                                                        if($sem['codeSemestre'] == 1) {
                                                            echo "I";
                                                        }
                                                        else  if($dec[2] == 2) {
                                                            echo "II";
                                                        }
                                                    }
                                                    else {
                                                        if($sem['codeSemestre'] == 1) {
                                                            echo "III";
                                                        }
                                                        else {
                                                            echo "IV";
                                                        }
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                foreach ($ues as $ue) {
                                    if($sem['codeSemestre'] == $ue['semestre']) {
                                    $nbr = ECU::getUEECUNumber($ue['idUE']);
                                    $ecus = ECU::getUEECU($ue['idUE']);
                                    $moyUE = (UE::read($ue['idUE']))->getMoyUE($idEtu);
                                    if($ue['codeTypeUE'] == "TC") {
                                        $validation = $laClasse->getValidationTC();
                                    }
                                    else {
                                        $validation = $laClasse->getValidationSP();
                                    }
                            ?>
                                <tr>
                                    <th scope="col" rowspan="<?php echo $nbr ?>" class=" text-sm" style="vertical-align:middle;text-align:center;"><?php echo $ue['codeUE'] ?></th>
                                    <td><?php echo $ecus[0]['libelleECU'] ?></td>
                                    <td style="vertical-align:middle;text-align:center;"><?php echo number_format(((ECU::read($ecus[0]['idECU']))->getMoyECU($idEtu, $ue['idUE'], $idClas)), 2); ?></td>
                                    <td rowspan="<?php echo $nbr ?>" style="vertical-align:middle;text-align:center;"><?php echo ($ue['coef'] < 10) ? "0".$ue['coef'] : $ue['coef']; $totalCredits+=$ue['coef']; ?></td>
                                    <td rowspan="<?php echo $nbr ?>" style="vertical-align:middle;text-align:center;"><?php echo ($moyUE>=$validation)? "Validé" : "Non validé"; ($moyUE>=$validation)? $creditsObtenus+=$ue['coef'] : $creditsObtenus+=0; ?></td>
                                </tr>
                                <?php
                                    $i = 0;
                                    $moyenneUECoef = 0.0;
                                    $moyenneUE = 0;
                                    foreach($ecus as $ecu):
                                        $moyECU = number_format(((ECU::read($ecu['idECU']))->getMoyECU($idEtu, $ue['idUE'], $idClas)), 2);
                                        $moyenneUE += $moyECU;
                                        if($i != 0):
                                ?>
                                        <tr>
                                            <td><?php echo $ecu['libelleECU'] ?></td>
                                            <td style="vertical-align:middle;text-align:center;"><?php echo $moyECU; ?></td>
                                        </tr>
                            <?php
                                        endif;
                                    $i++;
                                    endforeach;
                                    $moyenneUECoef = ($moyenneUE/$nbr)*$ue['coef'];
                                    $moyenne+=$moyenneUECoef;
                                    }
                                }
                                endforeach;
                            ?>
                            <tr class="font-weight-bold text-sm">
                                <th scope="col" rowspan="2"></th>
                                <td colspan="2">TOTAL DES CREDITS EN 
                                    <?php
                                        $dec = explode("-", $laClasse->getCodeClasse());
                                        if($dec[0] == "LP") {
                                            if($dec[2] == 1) {
                                                echo "L1 (SEMESTRE I + SEMESTRE II)";
                                            }
                                            else if($dec[2] == 2) {
                                                echo "L2 (SEMESTRE III + SEMESTRE IV)";
                                            }
                                            else if($dec[2] == 3) {
                                                echo "L2 (SEMESTRE V + SEMESTRE VI)";
                                            }
                                        }
                                        else if($dec[0] == "MP") {
                                            if($dec[2] == 1) {
                                                echo "M1 (SEMESTRE I + SEMESTRE II)";
                                            }
                                            else if($dec[2] == 2) {
                                                echo "M2 (SEMESTRE III + SEMESTRE IV)";
                                            }
                                        }
                                    ?>
                                </td>
                                <td class="text-center"><?php echo $totalCredits; ?></td>
                                <td></td>
                            </tr>
                            <tr class="font-weight-bold text-sm">
                                <td colspan="2">TOTAL DES CREDITS OBTENUS PAR LE CANDIDAT<?php  ?></td>
                                <td class="text-center"><?php echo $creditsObtenus ?></td>
                                <td class="text-center"><?php $moyenne=$moyenne/$totalCredits; echo number_format($moyenne, 2);?></td>
                            </tr>
                            </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>
                                        <span style="text-decoration: underline;">Résultat</span> : 
                                        <span class="font-weight-bold">
                                            <?php
                                                $dec = explode("-", $laClasse->getCodeClasse());
                                                $pourcent = ($creditsObtenus/$totalCredits)*100;
                                                if($dec[2] == (Niveau::read(Niveau::findNiveauId($dec[0])->getIdNiveau()))->getDuree() && $pourcent == 100) {
                                                    echo "ADMIS";
                                                }
                                                else if($dec[2] != (Niveau::read(Niveau::findNiveauId($dec[0])->getIdNiveau()))->getDuree() && $pourcent >=85) {    
                                                    echo "ADMIS";
                                                }
                                                else {
                                                    echo "REFUSE";
                                                }
                                            ?>
                                        </span><br>
                                        <span style="text-decoration: underline;">Mention</span> : 
                                        <span class="font-weight-bold">
                                            <?php
                                                if($moyenne >= 16) {
                                                    echo "TRES BIEN";
                                                }
                                                else if($moyenne >= 14) {
                                                    echo "BIEN";
                                                }
                                                else if($moyenne >= 12) {
                                                    echo "ASSEZ BIEN";
                                                }
                                                else {
                                                    echo "ECHEC";
                                                }
                                            ?>
                                        </span>
                                        <br>
                                    </p>
                                </div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-5">
                                    <p>
                                        Le Directeur,<br><br><br>
                                        <span class="font-weight-bold" style="text-decoration: underline;">Dr. Henri A. TCHOKPONHOUE</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-sm text-center" style="border-top : 1px solid black;">
                                    <span style="text-decoration: underline;" class="font-weight-bold">NB</span> : Il n'est délivré qu'une attestation de réussite. Il appartient au récipiendaire d'en établir des copies et de les faire certifier conformes par les autorités compétentes
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <div class="container-fluid">
                            <div class="row mb-4">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPrint('bulletin')" id="print-bulletin"><i class="fas fa-print" aria-hidden="true"></i> Imprimer</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPDF('bulletin', '<?php echo 'Bulletin '.$etuObject->getMatriculeEtu().' '.$annee->getAnnee() ?>')" id="<?php echo 'download-'.$evaluation['idEvaluation']; ?>"><i class="fas fa-file-pdf" aria-hidden="true"></i> PDF</button>
                                </div>
                            </div>
                        </div>
                        <script>
                            function toPDF(ind, code){
                                const invoice = this.document.getElementById(ind);
                                var opt = {
                                    margin:       0.3,
                                    filename:     code+'.pdf',
                                    image:        { type: 'jpeg', quality: 0.98 },
                                    html2canvas:  { scale: 2 },
                                    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait', fontName: 'Times new roman'}
                                };
                                html2pdf().from(invoice).set(opt).save();
                            };

                            function toPrint(ind) {
                                $('#'+ind).printThis({
                                    
                                    debug: false,               // show the iframe for debugging
                                    importCSS: true,            // import parent page css
                                    importStyle: false,         // import style tags
                                    printContainer: true,       // print outer container/$.selector
                                    loadCSS: "http://127.0.0.1/Schosys2/Ressources/Dashboard/dist/css/adminlte.min.css",              // path to additional css file - use an array [] for multiple
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
