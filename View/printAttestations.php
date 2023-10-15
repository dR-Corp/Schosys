<?php
    session_start();
    if(isset($_SESSION['username']) && ($_SESSION["codeProfil"] != "CS")){
        Header("Location: tableau-de-bord");
    }
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }    
?>

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
                        include_once '../Models/ClasseUE.class.php';
                        include_once '../Models/TypeEval.class.php';
                        include_once '../Models/ECU.class.php';
                        include_once '../Models/Etudiant.class.php';
                        include_once '../Models/Classe.class.php';
                        include_once '../Models/Etudier.class.php';
                        include_once '../Models/Obtenir.class.php';
                        include_once '../Models/Filiere.class.php';

                        include("Headers/titres.php");
                        
                    ?>
                </div>
                <!--<div class="col-sm-3">
                    <a href="detailAttestation.php"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des notes"><i class="fas fa-angle-double-left" aria-hidden="true"></i> Ton Attestation !</button></a>
                </div>-->
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card elevation-1" id="attestation">
                        <div class="card-body">
                            <h4>
                                <?php

                                    if(isset($_GET['filiere'])) {
                                         $libelleFiliere = $_GET['filiere'];
                                     }
                                
                                    if(isset($_GET['idEtu'])) {
                                        $idEtudiant = $_GET['idEtu'];
                                        //print($idEtudiant);
                                        $etudiant = Etudiant::read($idEtudiant);
                                        $matricule = $etudiant->getMatriculeEtu();
                                        $sexe = $etudiant->getSexeEtu();
                                        $nom = $etudiant->getNomEtu();
                                        $prenom = $etudiant->getPrenomEtu();
                                        $naissance = $etudiant->getDateNaissanceEtu();
                                        $mdate = explode('-', $naissance);
                                        $lieu = $etudiant->getLieuNaissanceEtu();
                                        $libelleNiveau = $etudiant->getCycleEtu()[1];
                                        
                                        // le cycle de l'étudiant
                                        $cycle = $etudiant->getCycleEtu()[0];
                                        
                                        // Première année de l'étudiant
                                        $debut = $etudiant->findAnneeStart();

                                    }
                                ?>
                            </h4>
                            <div class="row" style="padding-top: 120px;"></div>
                            <div class="row text-center">
                                <div class="col-sm-12">
                                    <!-- <h1><span class="font-weight-bold">ATTESTATION DE SUCCES</span></h1> -->
                                    <img class="img-responsive col-lg-11 col-sm-11" src="../Ressources/img/attestation.png" alt="titre asttestaion">
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-sm-12">
                                    <h5 class=" font-weight-bold"><span>N°________</span><span>-<?php echo $date = date('Y'); ?>/IUT-UP/DA/SSS/SGE/CDS</span></h5>
                                </div>
                            </div>
                            <div class="row text-lg text-justify">
                                <div class="col-sm-12">
                                    <p><span class="ml-5">Vu</span> les textes en vigueur portant organisation des enseignements et régimes des évaluations à l'<strong>I</strong>nstitut <strong>U</strong>niversitaire de <strong>T</strong>echnologie (<strong>IUT</strong>) de l'Université de Parakou;</p>
                                    <p><span class="ml-5">Vu</span> les procès verbaux de délibération;</p>
                                    <p><span class="ml-5">Le</span> Directeur de l'<strong>I</strong>nstitut <strong>U</strong>niversitaire de <strong>T</strong>echnologie (IUT) de l'Université de Parakou, soussigné, atteste que <?php if($sexe =='M'){ echo "Monsieur ";} else if($sexe =='F'){ echo "Madame ";} ?> <em><?php echo '<span class="font-weight-bold">'.$nom.' '.$prenom.'</span>' ?></em>, <?php echo ($sexe =='M')? "Né": "Née";?> <?php echo 'le <span class="font-weight-bold">';      
                                            setlocale(LC_TIME, "fr_FR.utf8", 'fra');
                                            echo ($mdate[2]<10)? ' 0'.$mdate[2] : ' '.$mdate[2];
                                            echo ' <span class="text-capitalize">'.strftime("%B", strtotime($naissance)).'</span> '.$mdate[0]; echo ' à '.$lieu.'</span> et '; echo ($sexe =='M')? "inscrit": "inscrite"; echo ' sous le N°<span class="font-weight-bold">'.$matricule.'</span>, a terminé avec succès le '; if($cycle==1){echo "premier";}else if($cycle==2){echo "deuxième";}else if($cycle==3){echo "troisième";} echo " cycle de formation à l'"?><strong>IUT</strong><?php echo " et rempli toutes les conditions pour l'obtention du diplôme de $libelleNiveau en "?><strong><?php echo strtoupper($libelleFiliere)." (Promotion ".$etudiant->findAnneeStart()."-".($etudiant->findAnneeStart()+3).").";?></strong>
                                    </p>
                                    <p><span class="ml-5">En</span> foi de quoi, la présente attestation lui est délivrée pour servir et valoir ce que de droit.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5 font-weight-bold">
                                    <p>
                                        Fait à Parakou, le 
                                        <?php
                                            $date = date('Y-m-d');
                                            setlocale(LC_TIME, "fr_FR.utf8", 'fra');
                                            echo ' '.date("d").' <span class="text-capitalize">'.strftime("%B", strtotime($date)).'</span> '.date("Y");
                                        ?>
                                        <br>
                                        Le Directeur,
                                    </p><br><br>
                                    <p style="text-decoration: underline;">
                                        Dr. Henri A. TCHOKPONHOUE
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-sm text-center" style="border-top : 1px solid black;">
                                    <span style="text-decoration: underline;" class="font-weight-bold">NB</span> : Il n'est délivré qu'une attestation de succès. Il appartient au récipiendaire d'en établir des copies et de les faire certifier conformes par les autorités compétentes
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <div class="container-fluid">
                            <div class="row mb-4">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPrint('attestation')" id="print-bulletin"><i class="fas fa-print" aria-hidden="true"></i> Imprimer</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPDF('attestation', '<?php echo 'Attestation '.$matricule.' '.$annee->getAnnee() ?>')" id="<?php echo 'download-'.$evaluation['idEvaluation']; ?>"><i class="fas fa-file-pdf" aria-hidden="true"></i> PDF</button>
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
                                    jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape', fontName: 'Times new roman'}
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

    function selectionner(selectId, optionValToSelect) {
  
        var selectElement = document.getElementById(selectId);
        var selectOptions = selectElement.options;
        for (var opt, j = 0; opt = selectOptions[j]; j++) {
            if (opt.value == optionValToSelect) {
                selectElement.selectedIndex = j;
                break;
            }
        }
    }

    </script>

</body>
</html>