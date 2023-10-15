<?php
    session_start();
    if(isset($_SESSION['username']) && $_SESSION["codeProfil"] != "COM" && $_SESSION["codeProfil"] != "DA"){
        Header("Location: tableau-de-bord");
    }
    if(!isset($_SESSION['username'])) {
        Header("Location: connexion");
    }

    
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
                    <?php
                        
                        include("Headers/titres.php");

                        if(isset($_POST['typeEval']) && !empty($_POST['typeEval']) && isset($_POST['ecu']) && !empty($_POST['ecu']) && isset($_POST['niveau']) && !empty($_POST['niveau']) && isset($_POST['filiere']) && !empty($_POST['filiere']) && isset($_POST['classe']) && !empty($_POST['classe']) ) {
                            
                            $idNiveau = $_POST['niveau'];
                            $codeNiveau = (Niveau::read($idNiveau))->getCodeNiveau();

                            $idFiliere = $_POST['filiere'];
                            $codeFiliere = (Filiere::read($idFiliere))->getCodeFiliere();

                            $idClasse = $_POST['classe'];
                            $codeClasse = (Classe::read($idClasse))->getCodeClasse();
                            
                            $idECU = $_POST['ecu'];
                            $codeECU = (ECU::read($idECU))->getCodeECU();
                            
                            $codeTypeEval = $_POST['typeEval'];
                            $libelleTypeEval = (TypeEval::read($codeTypeEval))->getLibTypeEval();

                        }
                        else if(isset($_GET['typeEval']) && isset($_GET['ecu']) && isset($_GET['classe']) && isset($_GET['niveau']) && isset($_GET['filiere'])) {
                            
                            $idNiveau = $_GET['niveau'];
                            $codeNiveau = (Niveau::read($idNiveau))->getCodeNiveau();

                            $idFiliere = $_GET['filiere'];
                            $codeFiliere = (Filiere::read($idFiliere))->getCodeFiliere();

                            $idClasse = $_GET['classe'];
                            $codeClasse = (Classe::read($idClasse))->getCodeClasse();
                            
                            $idECU = $_GET['ecu'];
                            $codeECU = (ECU::read($idECU))->getCodeECU();
                            
                            $codeTypeEval = $_GET['typeEval'];
                            $libelleTypeEval = (TypeEval::read($codeTypeEval))->getLibTypeEval();

                        }
                        
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

                    <?php
                               
                        $niveaux = Niveau::getAllNiveau($annee->getIdAnnee());
                        $filieres = Filiere::getAllFiliere($annee->getIdAnnee());
                        $classes = Classe::getAllClasse($annee->getIdAnnee());
                        $ecus = ECU::getAllECU($annee->getIdAnnee());
                        $typeevals = TypeEval::getAllTypeEval();
                        
                    ?>
                    
                    <div class="pt col-sm-0 float-left"></div>
                    <div class="card pt-2 pl-2 col-sm-12 mb-3 bg-gray">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="mb-2 row" id="form_filter">   
                            
                            <div class="form-group input-group-sm mb-1 mt-1 col-md-2">
                                <label for="niveau_note" class="mr-2">Niveau</label>
                                <select class="custom-select" name="niveau" id="niveau_note">
                                    <option value=""></option>
                                    <?php foreach($niveaux as $niveau): ?>
                                    <option value="<?php echo $niveau['idNiveau'] ?>" <?php if(isset($idNiveau) && !empty($idNiveau) && $niveau['idNiveau']==$idNiveau) {echo 'selected';} ?>><?php echo $niveau['codeNiveau'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group input-group-sm mb-1 mt-1 col-md-2">
                                <label for="filiere_note" class="mr-2">Filière</label>
                                <select class="custom-select" name="filiere" id="filiere_note">
                                    <option value=""></option>
                                    <?php foreach($filieres as $filiere): ?>
                                    <option value="<?php echo $filiere['idFiliere'] ?>" <?php if(isset($idFiliere) && !empty($idFiliere) && $filiere['idFiliere']==$idFiliere) {echo 'selected';} ?>><?php echo $filiere['codeFiliere'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group input-group-sm mb-1 mt-1 col-md-2">
                                <label for="classe_note" class="mr-2">Classe</label>
                                <select class="custom-select" name="classe" id="classe_note">
                                    <option value=""></option>
                                    <?php foreach($classes as $classe): ?>
                                    <option value="<?php echo $classe['idClasse'] ?>" <?php if(isset($idClasse) && !empty($idClasse) && $classe['idClasse']==$idClasse) {echo 'selected';} ?>><?php echo $classe['codeClasse'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group input-group-sm mb-1 mt-1 col-md-2">
                                <label for="ecu_note" class="mr-2">ECU</label>
                                <select class="custom-select" name="ecu" id="ecu_note">
                                    <option value=""></option>
                                    <?php foreach($ecus as $ecu): ?>
                                    <option value="<?php echo $ecu['idECU'] ?>" <?php if(isset($idECU) && !empty($idECU) && $ecu['idECU']==$idECU) {echo 'selected';} ?>><?php echo $ecu['codeECU'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group input-group-sm mb-1 mt-1 col-md-2">
                                <label for="typeEval_note" class="mr-2">Evaluation</label>
                                <select class="custom-select" name="typeEval" id="typeEval_note">
                                    <option value=""></option>
                                    <?php foreach($typeevals as $typeeval): ?>
                                    <option value="<?php echo $typeeval['codeTypeEval'] ?>" <?php if(isset($codeTypeEval) && !empty($codeTypeEval) && $typeeval['codeTypeEval']==$codeTypeEval) {echo 'selected';} ?>><?php echo $typeeval['libelleTypeEval'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>
                            <div class="form-group input-group-sm mb-1 mt-1 col-md-2">
                                <label for=""></label>
                                <input type="submit" name="search_note" value="Rechercher" id="search_note" class="btn btn-block btn-md btn-info">
                            </div>
                        </form>
                    </div>

                    <div id="show_note">
                    <?php if( (isset($_POST['typeEval']) && !empty($_POST['typeEval']) && isset($_POST['ecu']) && !empty($_POST['ecu']) && isset($_POST['niveau']) && !empty($_POST['niveau']) && isset($_POST['filiere']) && !empty($_POST['filiere']) && isset($_POST['classe'])  && !empty($_POST['classe'])) || (isset($_GET['typeEval']) && isset($_GET['ecu']) && isset($_GET['classe']) && isset($_GET['niveau']) && isset($_GET['filiere'])) ) { ?>
                    
                        <!-- ******************* Début du formulaire de modification de notes ************************** -->
                        <form action="../Controllers/modifierNotes.php?ecu=<?php echo $idECU ?>&amp;classe=<?php echo $idClasse ?>&amp;typeEval=<?php echo $codeTypeEval ?>&amp;annee=<?php echo $annee->getIdAnnee() ?>&amp;filiere=<?php echo $idFiliere ?>&amp;niveau=<?php echo $idNiveau ?>" method="post" id="form_notes">

                        <div class="card elevation-1">
                            <div class="card-body">
                                <h5 class="text-center text-uppercase" style="text-decoration: underline;">
                                    <?php echo isset($codeClasse) ? Classe::read($idClasse)->getLibClasse() : ""; ?>
                                </h5>
                                <h5 class="text-center text-uppercase" style="text-decoration: underline;">
                                    <?php echo isset($codeTypeEval) ? TypeEval::read($codeTypeEval)->getLibTypeEval()." de " : ""; echo isset($idECU) ? ECU::read($idECU)->getLibECU() : "";  ?>
                                </h5>
                                <table id="table_notes" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Matricules</th>
                                        <th scope="col">Noms et prénoms</th>
                                        <th scope="col">Notes</th>
                                        <th hidden scope="col">idEtudiant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $etudes = Etudier::getAllEtudier($annee->getIdAnnee());
                                    $id = 1;

                                    foreach((Etudiant::getAllEtudiant($annee->getIdAnnee())) as $etu){

                                    foreach ($etudes as $etude) {
                                        if($etude['idClasse'] == $idClasse) {
                                            $idEtudiant = $etude['idEtudiant'];
                                            //Récupération des étudiants de la classe
                                            if($etu['idEtudiant'] == $idEtudiant){

                                            $etudiant = Etudiant::read($idEtudiant);
                                            //Récupération des leur notes
                                            $evaluation = Evaluation::getTypeEvalECUEval($idECU, $codeTypeEval);
                                            $obtenir = Obtenir::read($evaluation, $idEtudiant);
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $id ?></th>
                                        <td><?php echo $etudiant->getMatriculeEtu() ?></td>
                                        <td><?php echo $etudiant->getNomEtu() ." ". $etudiant->getPrenomEtu() ?></td>
                                        <td>
                                            <?php
                                                if($obtenir) {
                                                    print '<input type="number" min="0" max="20" step="0.01" class="form-control" value="'.$obtenir->getNote().'" name="'.$idEtudiant.'" id="'.$idEtudiant.'">';
                                                }
                                            ?>
                                        </td>
                                        
                                        <td hidden><?php echo $etudiant->getIdEtudiant(); ?></td>
                                    </tr>
                                <?php
                                        $id++;
                                        }
                                    }
                                        }
                                    }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Matricules</th>
                                        <th scope="col">Noms et prénoms</th>
                                        <th scope="col">Notes</th>
                                        <th hidden scope="col">idEtudiant</th>
                                    </tr>
                                </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                            <input type="submit" value="Enregistrer les modifications" name="modifier" class="btn btn-block btn-outline-primary">
                        </form>
                        <!-- ***********************  Fin du formulaire  *********************** -->
                    <?php } ?>
                    </div>

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

    <!-- script pour modifierNotes.php -->
    <script>

    $(document).ready(function () {
    //$('#show_note').hide(slow);
    });

    $(document).ready(function() {
        $('#search_note').submit(function(event) {
        event.preventDefault();

        alert("ddddddddddddddd");

        var niveau = $('#niveau_note').val();
        var filiere = $('#filiere_note').val();
        var classe = $('#classe_note').val();
        var ecu = $('#ecu_note').val();
        var typeEval = $('#typeEval_note').val();

        if(niveau!="" && filiere!="" && classe!="" && ecu!="" && typeEval!="") {
        
        $('#show_note').slideDown(slow);
        }    

        });
    });
    </script>

</body>
</html>
