<?php
    session_start();
    if(isset($_SESSION['username']) && ($_SESSION["codeProfil"] != "CS" && $_SESSION["codeProfil"] != "DA")){
        Header("Location: tableau-de-bord");
    }
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
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
                        include_once '../Models/ClasseUE.class.php';
                        include_once '../Models/TypeEval.class.php';
                        include_once '../Models/ECU.class.php';
                        include_once '../Models/UE.class.php';
                        include_once '../Models/Etudiant.class.php';
                        include_once '../Models/Classe.class.php';
                        include_once '../Models/Etudier.class.php';
                        include_once '../Models/Obtenir.class.php';
                        include_once '../Models/Filiere.class.php';

                        if(isset($_GET['idClasse'])) {
					        $classeId = $_GET['idClasse'];
				        //La classe
                    		$classe = Classe::read($classeId);
                    		$codeClasse = $classe->getCodeClasse();
					    }


                        include("Headers/titres.php");
                         //ID de la classe
                                            ?>
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
                	
					
                    <div class="card" id="liste_etudiant">
                        <div class="card-body">
                            <?php 
                            //La filière
                                    $filiere = Filiere::read($classe->getIdFiliere());
                                    //Année d'étude
                                    $anneeEtude = (explode("-",(Classe::read($classeId))->getCodeClasse()))[2];
                             ?>
                            <div class="row">
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
                            	<div class="col-sm-1"></div>
                                <div class="col-sm-11">

                                	<h5><span style="text-decoration: underline;">Journée du :</span><span> ...............................................................</span></h5>
                                	<h5><span style="text-decoration: underline;">Matière :</span><span> .....................................................................</span></h5>
                                	<h5><span style="text-decoration: underline;">Enseignant :</span><span> ...............................................................</span></h5>
                                </div>
                            </div>
                            <div class="row">
                            	<div class="col-sm-1"></div>
                                <div class="col-sm-11">
								  <h5 class=" font-weight-bold"><span style="text-decoration: underline;">Filière :</span><span> <?php echo $filiere->getLibFiliere(); ?> </span></h5>
                                </div>
                            </div><br>

                            <table id="<?php echo $classe->getCodeClasse() ?>" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">N°</th>
                                    <th class="text-center" scope="col">Nom et prénoms</th>
                                    <th class="text-center" scope="col">Matin</th>
                                    <th class="text-center" scope="col">Soir&nbsp;&nbsp;&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $etudiants = Classe::getAllEtu_Classe($classeId,$annee->getIdAnnee());
                            $id=1;
                            	foreach ($etudiants as $etudiant) {
                            	?>
                            	<tr>
                                    <th scope="row"><?php echo $id ?></th>
                                    <td><?php if(isset($etudiant['nom']) && isset($etudiant['prenom'])) echo $etudiant['nom'] ." ". $etudiant['prenom']  ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php
                                $id++;
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
                            </table><br>
                            <div class="row">
                            	<div class="col-sm-1"></div>
                                <div class="col-sm-11" style="text-align: top">
                                	<h5><span style="text-decoration: underline;">Fait à Parakou le :</span><span> ....................................................................</span></h5>
                                	<h5><span style="text-decoration: underline;">Responsable de salle :</span><span> ............................................................</span></h5>
                                </div>
                            </div>
                        </div>  
                        </div> 

						<div class="container-fluid">
                            <div class="row mb-4">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-2"> 
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPrint('liste_etudiant')" ><i class="fas fa-print" aria-hidden="true"></i> Imprimer</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-info btn-sm btn-block" onclick="toPDF('liste_etudiant', '<?php echo $classe->getCodeClasse() ?>')"><i class="fas fa-file-pdf" aria-hidden="true"></i> PDF</button>
                                </div>
                            </div>
                        </div>

                        <script>
                            function toPDF(ind, code){
                                const invoice = this.document.getElementById(ind);
                                var opt = {
                                    margin:       0.3,
                                    filename:     "Liste :"+code+'.pdf',
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
        </div>
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

