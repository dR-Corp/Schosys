<?php
    session_start();
    if(isset($_SESSION['username']) && ($_SESSION["codeProfil"] != "CS" && $_SESSION["codeProfil"] != "DA")){
        Header("Location: tableau-de-bord");
    }
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }
    if(isset($_GET['idUE'])) {
        $idue = $_GET['idUE'];
    }
    if(isset($_GET['idECU'])) {
        $idecu = $_GET['idECU'];
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
                <div class="col-sm-10">
                    <?php
                        include_once '../Models/Evaluation.class.php';
                        include_once '../Models/ClasseUE.class.php';
                        include_once '../Models/TypeEval.class.php';
                        include_once '../Models/ECU.class.php';
                        include_once '../Models/UE.class.php';
                        include_once '../Models/Etudiant.class.php';
                        include_once '../Models/Classe.class.php';
                        include_once '../Models/Etudier.class.php';
                        include_once '../Models/Obtenir.class.php';
                        include_once '../Models/Filiere.class.php';

                        include("Headers/titres.php");
                        
                    ?>
                </div>
                <div class="col-sm-2">
                    <a href="../releves-de-notes-liste-ecu"><button class="btn btn-info btn-sm btn-block" data-tog="tooltip" data-placement="left" title="Gestion des notes"><i class="fas fa-angle-double-left" aria-hidden="true"></i> Retour</button></a>
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
                    
                    <?php
                        
                        $ecu = ECU::read($idecu);
                        $ue = $ecu->getIdUE();
                        
                        $order = 0;
                        $classe_ue = ClasseUE::read($ue);
                        $classeIds = explode(",",$classe_ue->getidClasse());
                        foreach($classeIds as $classeId) {
                            $order++;
                            ?>
                            <h4 class="text-center w-full py-2 bg-info text-white font-weight-bold">
                                <?php
                                    $classe = Classe::read($classeId);
                                    echo $classe->getCodeClasse();
                                ?>
                            </h4>
                            <?php

                            $evaluations = Evaluation::getAllEvaluation($annee->getIdAnnee());
                            foreach($evaluations as $evaluation) {
                    
                                if($evaluation['idECU'] == $idecu && $evaluation['codeTypeEval']=="CC") {
                                    //La filière
                                    $filiere = Filiere::read($classe->getIdFiliere());
                                    //Année d'étude
                                    $anneeEtude = (explode("-",(Classe::read($classeId))->getCodeClasse()))[2];
                    ?>
                    
                    <div class="card" id="<?php echo $order ?>">
                        <div class="card-body">
                            <h4>
                                <?php
                                    $typeeval = TypeEval::read($evaluation['codeTypeEval']);
                                ?>
                            </h4>
                            <div class="row text-sm">
                                <div class="col-sm-6 text-center" style="width: 50%;">
                                    <p>
                                        UNIVERSITE DE PARAKOU<br>******<br>INSTITUT UNIVERSITAIRE DE TECHNOLOGIE<br>******
                                    </p>
                                </div>
                                <div class="col-sm-6 text-center" style="width: 50%;">
                                    <p>ANNEE ACADEMIQUE<?php print " ". $annee->getAnnee(); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <h4 class=" font-weight-bold"><span style="text-decoration: underline;">Filière :</span><span class="text-uppercase"><?php echo " ".$filiere->getLibFiliere()." (".$filiere->getCodeFiliere().") ".$anneeEtude ?></span></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-11" style="margin-left: 70px;">
                                    <?php
                                        //Gestion de l'apostrophe pour le cas où de libelle du type d'examen commence par une voyelle
                                        $l = $typeeval->getLibTypeEval();
                                        if($l[0] == "A" || $l[0] == "E" || $l[0] == "I" || $l[0] == "O" || $l[0] == "U" || $l[0] == "Y") {
                                        ?>
                                            <p>PROCES VERBAL DES NOTES D'<span class="text-uppercase"><?php echo $typeeval->getLibTypeEval() ?></span></p>
                                        <?php
                                        }
                                        else {
                                        ?>
                                            <p>PROCES VERBAL DES NOTES DE<span class="text-uppercase"><?php echo " ".$typeeval->getLibTypeEval() ?></span></p>
                                        <?php
                                        }
                                    ?>
                                    <p><span style="text-decoration: underline;">Matière :</span><span class="text-uppercase"><?php echo " ".(ECU::read($idecu))->getLibECU() ?></span></p>
                                </div>
                            </div>
                            
                            <table id="<?php echo $classe->getCodeClasse() ?>" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">N° Ordre </th>
                                    <th class="text-center" scope="col">Matricule</th>
                                    <th class="text-center" scope="col">Nom et prénoms</th>
                                    <th class="text-center" scope="col">Notes sur 20</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $etudes = Etudier::getAllEtudier($annee->getIdAnnee());
                                $id = 1;
                                
                                foreach((Etudiant::getAllEtudiant($annee->getIdAnnee())) as $etu){
                                    
                                foreach ($etudes as $etude) {
                                    if($etude['idClasse'] == $classeId) {
                                        $idEtudiant = $etude['idEtudiant'];
                                        //Récupération des étudiants de la classe
                                        if($etu['idEtudiant'] == $idEtudiant){

                                        $etudiant = Etudiant::read($idEtudiant);
                                        //Récupération des leurs notes
                                        $obtenir = Obtenir::read($evaluation['idEvaluation'], $idEtudiant);
                            ?>
                                <tr>
                                    <th class="text-center" scope="row"><?php if($id<10){echo "0".$id;}else{echo $id;} ?></th>
                                    <td class="text-center"><?php echo $etudiant->getMatriculeEtu() ?></td>
                                    <td><?php echo $etudiant->getNomEtu() ." ". $etudiant->getPrenomEtu() ?></td>
                                    <td class="text-center">
                                        <?php
                                            
                                            if($obtenir) {
                                                echo $obtenir->getNote();
                                            }

                                        ?>
                                    </td>
                                </tr>
                            <?php
                                    $id++;
                                        }
                                    }
                                }
                                    
                                }
                            ?>
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th scope="col">N°</th>
                                    <th scope="col">Matricules</th>
                                    <th scope="col">Noms et prénoms</th>
                                    <th scope="col">Notes</th>
                                </tr>
                            </tfoot> -->
                            </table>
                            <div class="row mt-3">
                                <div class="col-sm-6" style="width: 60%;"></div>
                                <div class="col-sm-6 font-weight-bold" style="width: 40%;">
                                    <p>
                                        Fait à Parakou, le 
                                        <?php
                                            $date = date('Y-m-d');
                                            setlocale(LC_TIME, "fr_FR.utf8", 'fra');
                                            echo ' '.date("d").' <span class="text-capitalize">'.strftime("%B", strtotime($date)).'</span> '.date("Y");
                                        ?>
                                        <br>
                                        Le Directeur Adjoint,
                                    </p>
                                    <p style="margin-top: 70px; text-decoration: underline;">
                                        Dr.
                                        <?php echo $_SESSION['firstname']." ".$_SESSION['name'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        
                        <div class="container-fluid">
                            <div class="row mb-4">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPrint('<?php echo $order ?>')" id="<?php echo 'print-'.$evaluation['idEvaluation']; ?>"><i class="fas fa-print" aria-hidden="true"></i> Imprimer</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPDF('<?php echo $order ?>', '<?php echo $evaluation['codeEval'].' '.Classe::read($classeId)->getCodeClasse() ?>')" id="<?php echo 'download-'.$evaluation['idEvaluation']; ?>"><i class="fas fa-file-pdf" aria-hidden="true"></i> PDF</button>
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

                        <?php
                                    }
                                }

                            } 

                        ?>
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
